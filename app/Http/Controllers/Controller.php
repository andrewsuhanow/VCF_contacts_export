<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use App\Models\DataCards;
use App\Models\deletedDataCards;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function first()
    {
/*
        //$handle = fopen("resource.txt", "r");
        //$str = fread ( $handle , 100 );
//        $str = file  ( "00001.vcf" );
//        for($i=0;$i<=count($str)-1; $i++)
//        {
//            echo ("<br/>");
//            echo $str[$i];
//        }


        $resultData = array(
            array(
                'FN'=>'xxx',
                'TEL'=>'+00000000000',
                'EMAIL'=>'xxx@xxx.com',
            ),
            array(
                'FN'=>'xx1',
                'TEL'=>'+00000000001',
                'EMAIL'=>'xxx@xxj.com',
            ),
        );
        $itemData = array(
            'FN'=>'xxx',
            'TEL'=>'+00000000000',
            'EMAIL'=>'xxx@xxx.com',
        );
        $currentCardReed = 0;


        //EMAIL;TYPE=PREF:Konstantin1284@gmail.com
        //TEL;TYPE=CELL:+380995065988
        //FN:Viva Company



        $AllFileStrings = file  ( "00001.-vcf-" );
        for($i=0;$i<=count($AllFileStrings)-1; $i++)
        {
//            $currCard = stripos($AllFileStrings[$i],'BEGIN:VCARD');
//            if($currCard=='true') {
//                $endCurrCard = stripos($AllFileStrings[$i],'BEGIN:VCARD');
//            }

            // 111111111111111111111111111111111111111111
            $str = stripos($AllFileStrings[$i],'BEGIN:VCARD');
            if($str=='true'){
                $itemData = array(
                    'FN'=>'---',
                    'TEL'=>'--------------',
                    'EMAIL'=>'-------------',
                );
            }
            // 22222222222222222222222222222222222222222
            $str = stripos($AllFileStrings[$i],'FN:');
            if($str=='true'){
                $itemData['FN'] = 'FN rrrr';
            }
            // 33333333333333333333333333333333333333333
            $str = stripos($AllFileStrings[$i],'TEL');
            if($str=='true'){
                $itemData['TEL'] = '+00000000000000';
            }
            // 4444444444444444444444444444444444444444
            $str = stripos($AllFileStrings[$i],'EMAIL');
            if($str=='true'){
                $itemData['EMAIL'] = 'wwwww@wwwww.com';
            }
            // 5555555555555555555555555555555555555555
            $str = stripos($AllFileStrings[$i],'END:VCARD');
            if($str=='true'){
                array_push($resultData, $itemData);
            }

           // rtrim($AllFileStrings[$i]);
            echo ("<br/>");
            echo $AllFileStrings[$i];

                echo ("=====");
                echo $str;
                echo ("=====");

        }



        //$line=[
        //    'key1'=>'value1',
        //];
        //file_put_contents("test123.json",json_encode($line));



*/

        //dd('fffff');
        echo ('dddddddd11111');
        return view('welcome');
    }


    // обновление временных данных в БД (вызываем при кнопке редактировать)
    public function UpdateCard(Request $request)
    {

        $CardId = DataCards::find($request->card['ID']);

        $CardId->name = $request->card['FN'];
        $CardId->telephone = $request->card['TEL'];
        $CardId->email = $request->card['EMAIL'];
        $CardId->save();

        return response()->json([
            'status' => 'success1 -----UpdateCard',
        ]);
    }

    // добавление новой карты
  public function addMewCard(Request $request)
    {

        $newCard = new DataCards();
        $newCard->name = $request->newCard['FN'];
        $newCard->telephone = $request->newCard['TEL'];
        $newCard->email = $request->newCard['EMAIL'];
        $newCard->is_time = 0;
        $newCard->save();

        return response()->json([
            'status' => 'success---addMewCard',
            //'aaa' => $request->newCard['FN'],
        ]);
    }

    // узнаем ID нужной нам карты
//    public function findCardIdByOtherData(Request $request)
//    {
//
//        $Cards = DataCards::where('name', $request->newCard['FN'])->get();
//
//        return response()->json([
//            'status' => 'success1---findCardIdByOtherData',
//            'Card' => $Cards,
//        ]);
//    }

    // удаление временных данных из БД (вызываем при переходе на страницу загрузки файла)
    public function DeleteTimeData(Request $request)
    {

        $DataCards = DataCards::where('is_time', -1)->get();

        for($i = 0; $i < count($DataCards); $i++){
            $DataCards[$i]->delete();
        }

        return response()->json([
            'status' => 'success1 -----DeleteTimeData',
            //'fileData' => $request->fileData[0]['FN'],
        ]);
    }

    // удалить одну карту их базы данных
    public function DeleteCard(Request $request)
    {

        $CardId = DataCards::find($request->id);
        $CardId->delete();


        return response()->json([
            'status' => 'success1 -----DeleteCard _1_',
            //'card' => $CardId,

        ]);
    }

 // удалить одну карту из базы данных и добавить в ее в архивную базу
    public function DeleteCardAndAddToStore(Request $request)
    {

        $CardId = DataCards::find($request->id);



        $newInDeleted = new deletedDataCards();
        $newInDeleted->name = $CardId->name;
        $newInDeleted->telephone = $CardId->telephone;
        $newInDeleted->email = $CardId->email;
        $newInDeleted->save();

        $CardId->delete();


        return response()->json([
            'status' => 'success1---DeleteCardAndAddToStore',
            //'card' => $CardId->name,

        ]);
    }

    public function saveTimeData(Request $request)
    {
        for($i=0; $i< count($request->fileData); $i++)
        {
            $new = new DataCards();
            $new->name = $request->fileData[$i]['FN'];
            $new->telephone = $request->fileData[$i]['TEL'];
            $new->email = $request->fileData[$i]['EMAIL'];
            $new->is_time = -1;
            $new->save();
        }

        return response()->json([
            'status' => 'success1 ----saveTimeData',
            //'fileData' => $request->fileData[0]['FN'],
        ]);
    }

    public function saveDataFromTimeData(Request $request)
    {

        $DataCards = DataCards::where('is_time', -1)->get();

        for($i = 0; $i < count($DataCards); $i++){

            $DataCards[$i]->is_time = 0;
            $DataCards[$i]->save();
        }

//        for($i=0; $i< count($request->fileData); $i++)
//        {
//            $new = new DataCards();
//            $new->name = $request->fileData[$i]['FN'];
//            $new->telephone = $request->fileData[$i]['TEL'];
//            $new->email = $request->fileData[$i]['EMAIL'];
//            $new->is_time = ;
//            $new->save();
//        }

        return response()->json([
            'status' => 'success1 ----saveDataFromTimeData',
            //'fileData' => $request->fileData[0]['FN'],
        ]);
    }


    public function loadDataFromBD(Request $request)
    {

        $DataCards = DataCards::where('is_time', $request->isTime)->get();

        return response()->json([
            'status' => 'success---loadTimeDataFromBD ',
            'DataCards' => $DataCards,
        ]);
    }

    // загрузить данные из базы 'deletedDataCards'
    public function loadDataFromStoreBD(Request $request)
    {

        $DataCards = deletedDataCards::get();

        return response()->json([
            'status' => 'success---loadDataFromStoreBD ',
            'DataCards' => $DataCards,
        ]);
    }

    // восстановить карту -> переместить из 'deletedDataCards' в 'DataCards' с индексом '0'
    public function restoreCard(Request $request)
    {

        $Card = deletedDataCards::where('id', $request->id)->get();


        $new = new DataCards();
        $new->name = $Card[0]->name;
        $new->telephone = $Card[0]->telephone;
        $new->email = $Card[0]->email;
        $new->is_time = 0;
        $new->save();


        $Card[0]->delete();


        return response()->json([
            'status' => 'success---restoreCard',
            //'Card' => $Card[0]->name,
        ]);
    }



    public function main(Request $request)
    {

        $resultData = array(
            /*array(
                'FN'=>'xxx',
                'TEL'=>'+00000000000',
                'EMAIL'=>'xxx@xxx.com',
            ),
            array(
                'FN'=>'xx1',
                'TEL'=>'+00000000001',
                'EMAIL'=>'xxx@xxj.com',
            ),*/
        );
        $itemData = array(
            'FN'=>'xx2',
            'TEL'=>'+00000000002',
            'EMAIL'=>'xxx@xx2.com',
        );
//        $itemData['FN'] = 'rrrr';
//        array_push($resultData, $itemData);





        $AllFileStrings = file  ( "00001.-vcf-" );
        for($i=0;$i<=count($AllFileStrings)-1; $i++) {

            // 111111111111111111111111111111111111111111
            $str = stripos($AllFileStrings[$i], 'BEGIN:VCARD');
            if ($str == 'true') {
                $itemData = array(
                    'FN' => '---',
                    'TEL' => '--------------',
                    'EMAIL' => '-------------',
                );
            }
            // 22222222222222222222222222222222222222222
            $strNum = stripos($AllFileStrings[$i], 'FN:');
            if ($strNum == 'true') {
                $strOrigin = rtrim($AllFileStrings[$i]);
                $strNum = stripos($strOrigin, ':');
                $strResult = mb_strcut ( $strOrigin , $strNum+1);
                $itemData['FN'] = $strResult;
            }
            // 33333333333333333333333333333333333333333
            $str = stripos($AllFileStrings[$i], 'TEL;');
            if ($str == 'true') {
                $strOrigin = rtrim($AllFileStrings[$i]);
                $strNum = stripos($strOrigin, ':');
                $strResult = mb_strcut ( $strOrigin , $strNum+1);
                $itemData['TEL'] = $strResult;
            }
            // 4444444444444444444444444444444444444444
            $str = stripos($AllFileStrings[$i], 'EMAIL');
            if ($str == 'true') {
                $strOrigin = rtrim($AllFileStrings[$i]);
                $strNum = stripos($strOrigin, ':');
                $strResult = mb_strcut ( $strOrigin , $strNum+1);
                $itemData['EMAIL'] = $strResult;
            }
            // 5555555555555555555555555555555555555555
            $str = stripos($AllFileStrings[$i], 'END:VCARD');
            if ($str == 'true') {
                array_push($resultData, $itemData);
            }
        }


//        $AllFileStrings = file  ( "00001.-vcf-" );
//        for($i=0;$i<=count($AllFileStrings)-1; $i++)
//        {
//            //$str = stripos($AllFileStrings[$i],'BEGIN:VCARD');
//            //rtrim($AllFileStrings[$i]);
//            //echo ("<br/>");
//            //echo $AllFileStrings[$i];
//        }



        return response()->json([
            'status' => 'success1',
            'file' => $resultData,
        ]);
    }
}
