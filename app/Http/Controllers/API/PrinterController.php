<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\ImagickEscposImage;
use Mike42\Escpos\Printer;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printFile(){  

        try {
            $connector = null;
            $connector = new WindowsPrintConnector("TestPrinter");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer -> text("Hello World!\n");
            $printer -> text("Test\n");
            $printer -> text("==========\n");
            $printer -> text("asdasd\n");
            $printer -> text("asdsad\n");
            $printer -> cut();
            
            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }

 // try {
    // Enter the share name for your USB printer here
    // $connector = null;
    // $connector = new WindowsPrintConnector("TestPrinter");
    // $connector = new NetworkPrintConnector("smb://192.168.1.8/TestPrinter");

    // $connector = new NetworkPrintConnector("192.168.1.87", 9100);

    // $connector = new WindowsPrintConnector("TestPrinter");
    // $profile = CapabilityProfile::load("simple");
    // $connector = new WindowsPrintConnector("smb://DESKTOP-TSL43VE/TestPrinter");
    // $printer = new Printer($connector, $profile);
    // // $connector = new WindowsPrintConnector("TestPrinter");


    // // $printer = new Printer($connector);

    // $printer -> text("Hello World!\n");
    // $printer -> text("This is a test\n");
    // $printer -> cut();

    // $printer -> close();

//         $printer = new Printer($connector);

//         $printer -> text("Hello World!\n");
//         $printer -> text("This is a test\n");
//         $printer -> cut();

//         $printer -> close();

// } catch (Exception $e) {
//     echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
// }


        // try{
        // // $connector = new NetworkPrintConnector("206.189.89.154", 9100);

        // // $connector = new WindowsPrintConnector("smb://DESKTOP-TSL43VE/TestPrinter");
        

        // // $connector = new WindowsPrintConnector("kingtechcomputers");


        // // $connector = new FilePrintConnector("TestPrinter");
        
        //     $connector = new WindowsPrintConnector("TestPrinter");
        //     $printer = new Printer($connector);
        
        //     $printer -> text("Hello\n");
        //     $printer -> setUpsideDown(true);
        //     $printer -> text("World\n");
        //     $printer -> feed(5);
        //     $printer -> cut();
        //     $printer -> close(); 

        // }catch(Exception $e) {
        //     echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        // }
        
    }
}
