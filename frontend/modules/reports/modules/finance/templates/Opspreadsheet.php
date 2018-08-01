<?php

namespace frontend\modules\reports\modules\finance\templates;

use yii2tech\spreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use common\models\lab\Lab;
use common\components\NumbersToWords;
 /**
* Bergel Cutara SRS-II
*/
class Opspreadsheet extends Spreadsheet
{

	/**
     * @var location the data provider for the view. This property is required.
     */
    public $location="";
    public $model; // model used for targeting specific cell for data placements
    public $model_receipt; //templates to be used
     //public $LOCATION =\Yii::$app->basePath.'\\modules\\reports\\modules\\lab\\templates\\';
    /**

	/**
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet|null $document spreadsheet document representation instance.
     */

	public function init(){
		$this->location = \Yii::$app->basePath.'\\modules\\reports\\modules\\finance\\templates\\';
                $this->loaddoc();
                
        }

    public function loaddoc()
    {
        $this->setDocument(IOFactory::load($this->location."OP.xlsx"));
            
               


        // Set cell A2 with a numeric value
        // $this->getDocument()->getActiveSheet()->setCellValue('A2', $this->template);
        $numbertowords=new NumbersToWords();
        $amountinwords=$numbertowords->convert($this->model->total_amount);
        $whole_number=(int)$this->model->total_amount;
        $remainder=$this->model->total_amount - $whole_number;
        if (!$remainder){
            $amountinwords.=" And 00/100";
        }
        $this->getDocument()->getActiveSheet()->setCellValue('S6', $this->model->transactionnum);
        $this->getDocument()->getActiveSheet()->setCellValue('S7', date('F d, Y',strtotime($this->model->order_date)));
        $this->getDocument()->getActiveSheet()->setCellValue('B16', $this->model->customer ? $this->model->customer->customer_name : "");
        $this->getDocument()->getActiveSheet()->setCellValue('B18', $this->model->customer ? $this->model->customer->completeaddress : "");
        $this->getDocument()->getActiveSheet()->setCellValue('H20', $amountinwords);
        $this->getDocument()->getActiveSheet()->setCellValue('Q23', $this->model->total_amount);
        
        
        
        
        
        
        
        
        
        
        
//        //loop each of each sample
//        foreach ($this->model->request->samples as $sample) {
//             # loop each of the anlyses
//            foreach ($sample->analyses as $analysis) {
//                
//                #displaying the analysis on a row in a table
//                
//                $this->getDocument()->getActiveSheet()->setCellValue('B'.$row, $analysis->testname); //testname or parameter
//                $this->getDocument()->getActiveSheet()->setCellValue('C'.$row, $analysis->method); //method
//
//                $this->getDocument()->getActiveSheet()->insertNewRowBefore($row+1, 1);
//                $row++; 
//            }
//         } 
//         $this->getDocument()->getActiveSheet()->removeRow($row);

         #set password
         $this->getDocument()->getActiveSheet()->getProtection()->setSheet(true);
         $this->getDocument()->getSecurity()->setLockWindows(true);
         $this->getDocument()->getSecurity()->setLockStructure(true);
         $this->getDocument()->getSecurity()->setWorkbookPassword("PhpSpreadsheet");

        // Parent::setDocument($document);
    }

     public function render()
    {
        //overrides the render so that it would do nothing with cdataactiveprovider
        return $this;
    }

   
}

?>