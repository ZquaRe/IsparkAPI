

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IsparkLib {

public function Park($data = array())
{     
    if(empty($data['lat']) || empty($data['lon'])) die('Lat veya Lon değerleri bulunamadı.');
    if(empty($data['parkid']))
    {
    $jsonDecode = self::IsparkAll(true);
      foreach ($jsonDecode as $key => $item) {
            $jsonDecode[$key]['myDistance'] = self::distance($item['Latitude'], $item['Longitude'], $data['lat'], $data['lon']);
        }

        array_walk($jsonDecode,function(&$ar){
    
     
            if(strpos($ar['myDistance'],'KM')!==false)
            {
               $a= str_replace('KM','',$ar['myDistance']);
               $b=str_replace(',','',$a);
              $ar['meter']=((int)$b)*10;
            }else{
          
              $a= str_replace('M','',$ar['myDistance']);
               $b=str_replace(',','',$a);
              $ar['meter']=((int)$b);
            }
          });
          
          $arr=uasort($jsonDecode,fn($a,$b)=>(int)$a['meter']<=>(int)$b['meter']);
          return $jsonDecode;

    }
    else
    {
            $jsonDecode = self::IsparkDetails($data['parkid'],true);
            unset($jsonDecode['AreaPolygon']);
            $jsonDecode['myDistance'] = self::distance($jsonDecode['Latitude'], $jsonDecode['Longitude'], $data['lat'], $data['lon']);
            return $jsonDecode;
    }
   
    
}

    private function IsparkAll($array = false)
    {
     return json_decode(self::cUrl('https://api.ibb.gov.tr/ispark/Park'),$array);
    }

    private function IsparkDetails(int $id, $array = false)
    {
        return $Park = json_decode(self::cUrl('https://api.ibb.gov.tr/ispark/ParkDetay?id='.$id),$array);    
    }
    
    private function distance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
      {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
      
        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
          pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
      
        $angle = atan2(sqrt($a), $b);   
        $number = number_format($angle * $earthRadius); /* +11 */
     
        if(strpos($number,","))  return substr($number,0,-1).' KM'; else return $number.' M';    
            
      }

    private function cUrl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}

?>

