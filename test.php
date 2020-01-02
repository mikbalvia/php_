<?php
$datapemain = [
    [ 'pemain'=> 'A', 'nilai'=> [], 'tambahan'=> [] ],
    [ 'pemain'=> 'B', 'nilai'=> [], 'tambahan'=> [] ],
    [ 'pemain'=> 'C', 'nilai'=> [], 'tambahan'=> [] ],
    [ 'pemain'=> 'D', 'nilai'=> [], 'tambahan'=> [] ]
];



function randomNilai($jumlahLempar,$key){
    global $datapemain;
    for ($i=0; $i <$jumlahLempar ; $i++) { 
        array_push($datapemain[$key]['nilai'],rand(1,6));
    }  
}

function removeNilai($key){
    global $datapemain;
    for ($i=0; $i <count($datapemain[$key]['nilai']) ; $i++) { 
        if ($datapemain[$key]['nilai'][$i]==6) {
            array_splice($datapemain[$key]['nilai'],$i,1);
            $i--;
        }elseif ($datapemain[$key]['nilai'][$i]==1) {
            array_splice($datapemain[$key]['nilai'],$i,1);
            $i--;
            if ($key===3) {
                array_push($datapemain[0]['tambahan'],1);
            }else{
                array_push($datapemain[$key+1]['tambahan'],1);
            }
        }
    }

}

$jumlahLempar = 6;
$cekAnggota = true;
$round = 1;
while ($cekAnggota==true) {
    echo '<br><br>Round '.$round.'<br><br>After dice rolled:<br>';
    foreach ($datapemain as $key=>$value) {
        if (count($value['nilai'])!=0) {
            $jumlahLempar=count($value['nilai']);
        }
        $datapemain[$key]['nilai']=[];
        $datapemain[$key]['tambahan']=[];
        randomNilai($jumlahLempar,$key);
        echo 'Player '.$value['pemain'].': '.implode(',',$datapemain[$key]['nilai']).'<br>';
    }
    foreach ($datapemain as $key=>$value) {
        removeNilai($key);
    }
    echo '<br>After dice moved/removed:<br>';

    foreach ($datapemain as $key=>$value) {
        $datapemain[$key]['nilai']=array_merge($datapemain[$key]['nilai'],$datapemain[$key]['tambahan']);
        echo 'Player '.$value['pemain'].': '.implode(',',$datapemain[$key]['nilai']).'<br>';
    }

    foreach ($datapemain as $key=>$value) {
        if (count($datapemain[$key]['nilai'])==0) {
            $cekAnggota=false;
            echo '<br>++++++<br><h2>Player '.$value['pemain'].' won</h2>';
        } 
    }
    
    $round++;
};
?>
