<?php

namespace App\Services\Admin;

use App\Exports\SimpleArrayExport;
use Dompdf\Dompdf;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Symfony\Component\HttpFoundation\Response;

class AdminExportService
{
  protected ViewFactory $viewFactory;

  public function __construct(ViewFactory $viewFactory)
  {
    $this->viewFactory = $viewFactory;
  }

  /**
   * @param array<int, string> $headings
   * @param array<int, array<int, string|int|float|null>> $rows
   * @param array<string, mixed> $meta
   */
  public function download(string $format, string $fileName, array $headings, array $rows, array $meta = []): Response
  {
    $format = strtolower($format);
    $safeFileName = Str::slug($fileName);

    if ($format === 'excel' || $format === 'xlsx') {
      return Excel::download(new SimpleArrayExport($headings, $rows), $safeFileName . '.xlsx', ExcelWriter::XLSX);
    }

    if ($format === 'csv') {
      return Excel::download(new SimpleArrayExport($headings, $rows), $safeFileName . '.csv', ExcelWriter::CSV);
    }

    if ($format === 'pdf') {
      return $this->downloadPdf($safeFileName, $headings, $rows, $meta);
    }

    abort(404, 'Unsupported export format.');
  }

  /**
   * @param array<int, string> $headings
   * @param array<int, array<int, string|int|float|null>> $rows
   * @param array<string, mixed> $meta
   */
  protected function downloadPdf(string $fileName, array $headings, array $rows, array $meta): Response
  {
    $dompdf = new Dompdf([
      'defaultFont' => 'Helvetica',
      'isHtml5ParserEnabled' => true,
      'isRemoteEnabled' => true,
    ]);

    $html = $this->viewFactory->make('admin.exports.table', [
      'headings' => $headings,
      'rows' => $rows,
      'meta' => $meta,
    ])->render();

    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('a4', 'landscape');
    $dompdf->render();

    $output = $dompdf->output();

    return response($output, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'attachment; filename="' . $fileName . '.pdf"',
    ]);
  }
}
