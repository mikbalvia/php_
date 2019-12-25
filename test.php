<?php

class Dadu {
   
    private $valSisiAtas;
    public function getvalSisiAtas()
    {
        return $this->valSisiAtas;
    }
    public function rolling()
    {
        $this->valSisiAtas =  rand(1,6);
        return $this;
    }
    public function setvalSisiAtas($valSisiAtas)
    {
        $this->valSisiAtas = $valSisiAtas;
        return $this;
    }
}
class pemain {
    private $daduDalamCup = array();
    private $nama;
    private $posisi;
    public function getdaduDalamCup()
    {
        return $this->daduDalamCup;
    }
    public function getnama()
    {
        return $this->nama;
    }
    public function getposisi()
    {
        return $this->posisi;
    }
    public function __construct($nomorDadu,$posisi,$nama='')
    {
        $this->posisi = $posisi;
        $this->nama = $nama;
        for($i=0;$i<$nomorDadu;$i++){
            array_push($this->daduDalamCup,new Dadu());
        }
    }
    public function play()
    {
        foreach($this->daduDalamCup as $dadu){
            $dadu->rolling();
        }
    }
    public function removedadu($key)
    {
       
        unset($this->daduDalamCup[$key]);
    }
    public function insertdadu($dadu)
    {
        array_push($this->daduDalamCup,$dadu);
    }
}
class Game{
    /** @var pemain[] $pemains */
    private $pemains = array();
    private $round;
    const NOMOR_DADU_TIAP_PEMAIN = 6;
    const NOMOR_PEMAIN = 4;
    const HAPUS_DADU = 6;
    const PINDAH_DADU = 1;
    public function __construct()
    {
        $this->round = 0;
        for($i=0;$i<self::NOMOR_PEMAIN;$i++){
            $this->pemains[$i] = new pemain(self::NOMOR_DADU_TIAP_PEMAIN,$i,chr(65+$i));
        }
    }
    public function Rounde()
    {
        echo "<strong>Round ".$this->round."</strong><br><br>\r\n";
        return $this;
    }
    public function tampilSisiAtasDadu($title='After dice rolled')
    {
        echo '<span style="text-decoration: underline;">'.$title.'</span><br>';
        foreach($this->pemains as $pemain){
            echo "Player ".$pemain->getnama().": ";
            $dadaSisiAtas = '';
            foreach($pemain->getdaduDalamCup() as $dadu){
                $dadaSisiAtas .= $dadu->getvalSisiAtas().", ";
            }
            echo rtrim($dadaSisiAtas,",")."<br>\r\n";
        }
        echo "<br><br>\r\n";
        return $this;
    }
    public function tampilWinner($pemain)
    {
        echo "<h3>Found Winner</h3>\r\n";
        echo "Player ".$pemain->getnama()."<br>\r\n";
        return $this;
    }
    public function start()
    {
        while(true){
            $this->round++;
            $daduNext = array();
            foreach($this->pemains as $pemain){
                $pemain->play();
            }
            $this->Rounde()->tampilSisiAtasDadu();
            foreach($this->pemains as $index=>$pemain){
                $daduArray = array();
                foreach($pemain->getdaduDalamCup() as $daduIndex=>$dadu){
                    if($dadu->getvalSisiAtas() == self::HAPUS_DADU){
                        $pemain->removedadu($daduIndex);
                    }
                    if($dadu->getvalSisiAtas() == self::PINDAH_DADU){
                        if($pemain->getposisi()==(self::NOMOR_PEMAIN-1)){
                            $this->pemains[0]->insertdadu($dadu);
                            $pemain->removedadu($daduIndex);
                        }
                        else{
                            array_push($daduArray,$dadu);
                            $pemain->removedadu($daduIndex);
                        }
                    }
                }
                $daduNext[$index+1] =$daduArray;
                if(array_key_exists($index,$daduNext) && count($daduNext[$index])>0){
                    foreach ($daduNext[$index] as $dadu) {
                        $pemain->insertdadu($dadu);
                    }
                    $daduNext = array();
                }
            }
            $this->tampilSisiAtasDadu("After dice moved/removed");
            $hitungPemenang=0;
            foreach($this->pemains as $pemain){
                if(count($pemain->getdaduDalamCup())<=0){
                    $this->tampilWinner($pemain);
                    $hitungPemenang++;
                }
            }
            if($hitungPemenang>0){
                break;
            }
        }
    }
}
$game = new Game();
$game->start();
