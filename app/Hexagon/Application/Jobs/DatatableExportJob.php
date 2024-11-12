<?php

namespace App\Hexagon\Application\Jobs;

use App\Hexagon\Application\Mail\ExportMail;
use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Domain\Exceptions\NotFoundException;
use App\Hexagon\Infrastructure\Repository\BaseRepository;
use App\Services\Enums\ExportType;
use App\Services\Enums\Notification\NotificationCategory;
use App\Services\Enums\Notification\NotificationType;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Notification\Mail\MailService;
use App\Services\Notification\Mail\SmtpMailFactory;
use App\Services\Notification\Pusher\NotificationDto;
use App\Services\Utils\File\FileSystemWorker;
use App\Services\Utils\Payload\NotificationPayload;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class DatatableExportJob implements ShouldQueue
{
    use Queueable;

    private DatatableRequestDto $datatableRequestDto;
    private string $locale = 'en';
    private string $email;
    private string $fullName;
    private string $exportDir;
    private string $exportUrl;

    /**
     * Create a new job instance.
     */
    public function __construct(DatatableRequestDto $datatableRequestDto, string $locale, string $email, string $fullName)
    {
        $this->datatableRequestDto = $datatableRequestDto;
        $this->locale = $locale;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->exportDir = config('uploads.temp_export_directory');
        $this->exportUrl = config('uploads.export_url');
    }

    /**
     * Execute the job.
     * @throws NotFoundException
     * @throws \Exception
     */
    public function handle(): void
    {
        DB::beginTransaction();
        $option = $this->datatableRequestDto;
        $locale = $this->locale;
        $email = $this->email;
        $fullName = $this->fullName;
        $repository = App::make(BaseRepository::class);
        $result = null;
        try {
            switch ($option->exportOption->type) {
                case ExportType::EXCEL->value:
                    $result = $this->excelExport($option, $repository);
                    break;

                case ExportType::CSV->value:
                    $result = $this->csvExport($option, $repository);
                    break;

                case ExportType::PDF->value:
                    $result = $this->pdfExport($option, $repository);
                    break;

            }
            if (!empty($result)) {
                $this->sendDownloadLinkByEmail($result, $email, $fullName);
//                $payload = $this->saveNotification($email, $locale, $result);
//                $message->setNotificationPayload($payload);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            if ($result && isset($result['fullPath']) && FileSystemWorker::pathExists($result['fullPath']))
                unlink($result['fullPath']);

            throw $exception;
        }

    }

    /**
     * @throws NotFoundException
     */
    private function saveNotification(string $email, string $locale, array $data): NotificationPayload
    {
        $notificationDto = new NotificationDto();
        $notificationDto->setType(NotificationType::SUCCESS);
        $notificationDto->setCategory(NotificationCategory::NEWS);
        $notificationDto->setExternalLink(null);
        $notificationDto->setInternalLink(null);
        $notificationDto->setFileLink($data['downloadLink']);
        $notificationDto->setEmail($email);
        $notificationDto->setTitleLocale(PayloadMessage::NOTIFICATION_EXPORT_TITLE);
        $notificationDto->setTitleLocaleOptions(null);
        $notificationDto->setContentLocale(PayloadMessage::NOTIFICATION_EXPORT_CONTENT);
        $notificationDto->setContentLocaleOptions(null);
        $notificationDto->setLocale($locale);
        return $this->notificationSaver->save($notificationDto);
    }

    // EXCEL - CSV START

    private function excelExport(DatatableRequestDto $option, BaseRepository $repository): array {
        return $this->makeSpreadsheet($option, $repository, 'xlsx');
    }

    private function csvExport(DatatableRequestDto $option, BaseRepository $repository): array {
        return $this->makeSpreadsheet($option, $repository, 'csv');
    }

    private function makeSpreadsheet(DatatableRequestDto $option, BaseRepository $repository, string $extension): array
    {
        $columns = $option->exportOption->columns;
        $fields = $this->getColumnsArray($columns);
        $limit = 10000;
        $page = 1;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;
        $col = 'A';
        $rowIndex = 2;
        $colIndex = 'A';
        foreach ($fields as $key => $field){
            $sheet->setCellValue($col.$i, $field)->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $matchingKeys = null;

        do {
            $option->limit = $limit;
            $option->page = $page;
            $data = $repository->fetchPagedDataForDatatable($option);
            if (empty($data['records']))
                break;

            $items = $data['records'];

            if (empty($matchingKeys))
                $matchingKeys = $this->findMatchingKeys(array_keys($items[0]), $fields);

            foreach ($items as $item) {
                $item = array_intersect_key($item, array_flip($matchingKeys));
                foreach ($item as $key => $dt) {
                    if (in_array($key,$matchingKeys)) {
                        $sheet->setCellValue($colIndex.$rowIndex, $dt)->getColumnDimension($colIndex)->setAutoSize(true);
                        $colIndex++;
                        if (array_key_last($item) === $key){
                            $rowIndex++;
                            $colIndex = 'A';
                        }
                    }
                }
//                $rowIndex++;
            }

            // Bellek temizleme
            unset($items); // İşlenmiş kayıtları bellekten çıkar
            gc_collect_cycles(); // Bellekte biriken gereksiz verileri temizle

            $page++;
        } while (!empty($data));

        $subFolder = "/" . strtolower($option->exportOption->type);
        $folder = $this->exportDir . $subFolder;
        FileSystemWorker::createFolderIfNotExist($folder);
        $fileName = $option->exportOption->fileName . "_export_" . date('Y-m-d_H-i-s') . '.' . $extension;
        $filePath = $folder . "/" . $fileName;
        $fullPath = $this->exportDir . $subFolder . "/" . $fileName;
        $downloadLink = $this->exportUrl . $subFolder . "/" . $fileName;
        $subject = PayloadMessage::EXCEL_DOWNLOAD_LINK_MESSAGE;
        $applicationName = "application/excel";

        $writer = $extension === 'csv' ? new Csv($spreadsheet) : new Xlsx($spreadsheet);
        if ($extension === 'csv') {
            $writer->setDelimiter(',');  // Virgül ile ayır
            $writer->setEnclosure('"');  // Tırnak işareti ile değerleri kapsa
            $writer->setLineEnding("\r\n"); // Satır sonu karakteri
            $writer->setSheetIndex(0); // Hangi sayfayı yazacağını belirt
            $subject = PayloadMessage::CSV_DOWNLOAD_LINK_MESSAGE;
            $applicationName = "application/csv";
        }

        $writer->save($filePath);

        return [
            'subjectLocaleKey' => $subject,
            'fullPath' => $fullPath,
            'downloadLink' => $downloadLink,
            'fileName' => $fileName,
            'applicationName' => $applicationName
        ];
    }

    // EXCEL - CSV END


    // PDF START


    private function pdfExport(DatatableRequestDto $option, BaseRepository $repository): array {
        $columns = $option->exportOption->columns;
        $fields = $this->getColumnsArray($columns);
        $limit = 10000;
        $page = 1;

        $matchingKeys = null;
        $dataForExport = [];
        // Sayfa sayfa veriyi getir ve tablo satırlarını ekle
        do {
            $option->limit = $limit;
            $option->page = $page;
            $data = $repository->fetchPagedDataForDatatable($option);

            if (empty($data['records'])) {
                break;
            }

            $items = $data['records'];

            if (empty($matchingKeys)) {
                $matchingKeys = $this->findMatchingKeys(array_keys($items[0]), $fields);
            }

            foreach ($items as $item) {
                $item = array_intersect_key($item, array_flip($matchingKeys));
                $dataForExport[] = $item;
            }

            // Bellek temizleme
            unset($items); // İşlenmiş kayıtları bellekten çıkar
            gc_collect_cycles(); // Bellekte biriken gereksiz verileri temizle

            $page++;
        } while (!empty($data));

        $html = view('export.pdf', [
            'fields' => $fields,
            'items' => $dataForExport,
            'title' => ucwords($option->exportOption->fileName)
        ])->render();

        // dompdf ayarları sayfa numarası ortada
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Arial');
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);


        $dompdf->loadHtml($html);

        // Paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Sayfa numaralarını eklemek için
        $dompdf->render();

        // Add page numbers after rendering
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "$pageNumber / $pageCount";
            $font = $fontMetrics->getFont('Arial');
            $size = 12;
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $pageWidth = $canvas->get_width();
            $x = ($pageWidth - $width) / 2; // Page number in the center
            $y = 820; // Y position
            $canvas->text($x, $y, $text, $font, $size);
        });

        // Dosyayı kaydet
        $subFolder = "/" . strtolower($option->exportOption->type);
        $folder = $this->exportDir . $subFolder;
        FileSystemWorker::createFolderIfNotExist($folder);
        $fileName = $option->exportOption->fileName . "_export_" . date('Y-m-d_H-i-s') . '.pdf';
        $filePath = $folder . "/" . $fileName;
        $fullPath = $this->exportDir . $subFolder . "/" . $fileName;
        $downloadLink = $this->exportUrl . $subFolder . "/" . $fileName;
        // PDF dosyasını belirlenen dizine kaydet
        file_put_contents($filePath, $dompdf->output());
        return [
            'subjectLocaleKey' => PayloadMessage::PDF_DOWNLOAD_LINK_MESSAGE,
            'fullPath' => $fullPath,
            'downloadLink' => $downloadLink,
            'fileName' => $fileName,
            'applicationName' => 'application/pdf'
        ];
    }

    // PDF END

    private function getColumnsArray(array $columns): array
    {
        $columnsArray = [];
        foreach ($columns as $key => $value){
            $columnsArray[$value['value']] = $value['label'];
        }
        return $columnsArray;
    }

    private function findMatchingKeys(array $keys, array $reference): array
    {
        $matchedKeys = [];

        foreach ($keys as $key) {
            if (array_key_exists($key, $reference)) {
                $matchedKeys[] = $key;
            }
        }

        return $matchedKeys;
    }

    /**
     * @throws \Exception
     */
    private function sendDownloadLinkByEmail(array $applicationData, string $email, string $fullName): void
    {
        $subjectLocaleKey = $applicationData['subjectLocaleKey'];
        $downloadLink = $applicationData['fullPath'];
        $fileName = $applicationData['fileName'];
        $applicationName = $applicationData['applicationName'];
        $subject = __($subjectLocaleKey);
        $attachments = [
            Attachment::fromPath($downloadLink)
                ->as($fileName)
                ->withMime($applicationName),
        ];
        $mailService = MailService::getInstance();
        $mailService->setTo($email);
        $mailService->setSubject($subject);
        $mailService->setData(['fullName' => $fullName]);
        $mailService->setMailable(ExportMail::class);
        $mailService->setAttachments($attachments);
        $mailService->send();
    }
}
