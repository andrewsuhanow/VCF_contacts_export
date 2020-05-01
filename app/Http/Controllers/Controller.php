<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use App\Models\DataCards;

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




    public function saveInformList(Request $request)
    {



        for($i=0; $i< count($request->fileData); $i++)
        {
            $new = new DataCards();
            $new->name = $request->fileData[$i]['FN'];
            $new->telephone = $request->fileData[$i]['TEL'];
            $new->email = $request->fileData[$i]['EMAIL'];
            $new->save();
        }

        return response()->json([
            'status' => 'success1',
            //'fileData' => $request->fileData[0]['FN'],
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
