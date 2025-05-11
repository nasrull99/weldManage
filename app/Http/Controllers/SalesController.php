<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationMaterial;
use App\Models\Invoice;
use App\Models\InvoiceMaterial;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    public function index()
    {
        $customerCount = Customer::count();
        $materialCount = Material::count();
        $quotationCount = Quotation::count();
        $invoiceCount = Invoice::count();
        $newCustomers = Customer::orderBy('created_at', 'desc')->take(5)->get();

        // Monthly income for the last 12 months
        $monthlyIncome = Invoice::selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, SUM(subtotal) as total")
            ->groupBy('month')
            ->orderByRaw("MIN(created_at)")
            ->take(12)
            ->get();

        return view('dashboard', compact('customerCount', 'newCustomers', 'materialCount', 'quotationCount', 'invoiceCount', 'monthlyIncome'));
    }

    public function view()
    {
        return view('salesreport');
    }

    public function showSales(Request $request)
    {
        // Get start and end dates from the request
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        // Format the dates to dd/mm/yyyy
        $startFormatted = Carbon::parse($start)->format('d/m/Y');
        $endFormatted = Carbon::parse($end)->format('d/m/Y');

        // Fetch sales data with the date of transaction (created_at)
        $salesData = Invoice::whereBetween('invoices.created_at', [$start, $end])
            ->join('custdetail', 'invoices.customer_id', '=', 'custdetail.id') 
            ->select('custdetail.name as customer_name', 'invoices.created_at as date', \DB::raw('SUM(invoices.subtotal) as total'))
            ->groupBy('custdetail.name', 'invoices.created_at')  // Group by customer name and date
            ->get();

        // Calculate total sales, total orders, and highest sale within the date range
        $totalSales = $salesData->sum('total');
        $totalOrders = Invoice::whereBetween('created_at', [$start, $end])->count();
        $highestSale = Invoice::whereBetween('created_at', [$start, $end])->max('subtotal');

        return view('salesreportPage', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'highestSale' => $highestSale,
            'start' => $startFormatted,
            'end' => $endFormatted,
        ]);
    }

    public function downloadSalesReport(Request $request)
    {
        // Parse the incoming dates as d/m/Y and convert to Y-m-d for the query
        $start = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))->format('Y-m-d');

        // Format for display in the PDF
        $startFormatted = Carbon::parse($start)->format('d/m/Y');
        $endFormatted = Carbon::parse($end)->format('d/m/Y');

        // Fetch sales data based on the date range
        $salesData = Invoice::whereBetween('invoices.created_at', [$start, $end])
            ->join('custdetail', 'invoices.customer_id', '=', 'custdetail.id')
            ->select('custdetail.name as customer_name', 'invoices.created_at as date', \DB::raw('SUM(invoices.subtotal) as total'))
            ->groupBy('custdetail.name', 'invoices.created_at')
            ->get();

        // Calculate total sales, total orders, and highest sale within the date range
        $totalSales = $salesData->sum('total');
        $totalOrders = Invoice::whereBetween('created_at', [$start, $end])->count();
        $highestSale = Invoice::whereBetween('created_at', [$start, $end])->max('subtotal');

        // Prepare the data for the PDF
        $data = [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'highestSale' => $highestSale,
            'start' => $startFormatted,
            'end' => $endFormatted
        ];

        // Load the PDF view
        $pdf = PDF::loadView('pdf-sales', $data);

        // Generate filename
        $fileName = 'sales_report_' . str_replace('/', '_', $startFormatted) . '_to_' . str_replace('/', '_', $endFormatted) . '.pdf';

        // Return the PDF for download
        return $pdf->download($fileName);
    }

}
