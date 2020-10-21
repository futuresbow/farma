<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Api extends CI_Controller {
    
    
    public function keszletmigralas() {
        
                    // termékkészlet migrálás külön táblába
            // TODO: kivenni!!
            ws_autoload("termek");
            define('DBP', '');
            // nem változatos termékek:
            $sql = "SELECT t.id FROM termekek t WHERE t.id NOT IN (SELECT k.termek_id FROM termek_armodositok k )";
            $valtozatNelkuliTermekek = $this->Sql->sqlSorok($sql);
            foreach($valtozatNelkuliTermekek as $vnt) {
                $tid = $vnt->id;
                
                $vanKeszletSor = $this->Sql->sqlSor("SELECT id FROM termek_keszletek WHERE termek_armodosito_id = 0 AND termek_id = $tid LIMIT 1");
                if(!$vanKeszletSor) {
                    // nincs, elékészítjük
                    $t = new Termek_osztaly($tid);
                    print 'nincs készletsor: '.$tid."<br>";
                    $a = array('termek_id' => $tid, 'termek_armodosito_id' => 0, 'keszlet' => $t->keszlet, 'lefoglalt' => $t->lefoglalva );
                    print_r ($a);print '<br><br>';
                    var_dump($this->Sql->sqlSave($a, 'termek_keszletek'));
                }
                
            }

        
    }
    
    public function termeklista() {
        define("DBP", '');

        $sql = "SELECT id FROM termekek";
        $termekIdk = $this->Sql->sqlSorok($sql);
        //print_r($termekIdk);
        $osszesId = array();
        foreach ($termekIdk as $tid)
            $osszesId[$tid->id] = $tid->id;


        $tCsoportok = $this->Sql->gets('termek_csoportok', "ORDER BY nev ASC");
        foreach ($tCsoportok as $csoport) {


            ob_start();

            $tt = array('id' => '6', 'cikkszam' => '0639266328780', 'eredeti_cikkszam' => '', 'ar' => '8267.71', 'eredeti_ar' => '0.00', 'penznem' => 'HUF', 'aktiv' => '0', 'afa' => '27', 'statusz' => '0', 'gyarto_id' => '18', 'vasarlasszam' => '0', 'termek_csoport_id' => '2', 'termekszulo_id' => '0', 'altermek_sorrend' => '0', 'letrehozva' => '2020-06-23 14:10:52', 'modositva' => '2020-10-15 10:42:26', 'keszlet' => '0', 'lefoglalva' => '0');
            foreach ($tt as $k => $v) {
                
                print '"' . $k . '";';
            }
            print "kategoriak;cimkek;valtozatok;valtozat-darabszamok;kepek;termek-csoport;keresostring;";
            $sql = "SELECT id FROM termekek WHERE termek_csoport_id = {$csoport->id} ORDER BY id ASC LIMIT 3000";
            $rs = $this->Sql->sqlSorok($sql);
            ws_autoload('termek');


            $t = new Termek_osztaly($rs[0]->id);

            $t->jellemzoBetoltes();



            $arr = array();
            if (!empty($t->jellemzok))
                foreach ($t->jellemzok as $k => $jellemzo) {

                    $felirat = $t->jellemzoFeliratTermelap($jellemzo->nev);
                    print '"' . $felirat . '";';
                }

            print "\n";
            
            $push = array();
            $tnev = 'export_termekek_' . str_replace('-','_',strToUrl($csoport->nev));

            $this->db->query("TRUNCATE ".$tnev);
            
            
            foreach ($rs as $t) {
                $t = new Termek_osztaly($t->id);
                
                unset($osszesId[$t->id]);
                
                foreach ($tt as $k => $v) {
                    $push[$k] = $t->{$k};
                    print '"' . $t->{$k} . '"' . ';';
                }
                $arr = array();
                if (!empty($t->ketagoriaTagsag))
                    foreach ($t->ketagoriaTagsag as $v) {
                        $a = $this->Sql->get($v, "kategoriak", 'id');
                        $arr[] = $a->nev;
                    }
                $kategoria = '"' . implode(",", $arr) . '";';
                print $kategoria;
                
                $push['kategorianevek'] = implode(",", $arr);
                
                $arr = array();
                if (!empty($t->cimkeTagsag))
                    foreach ($t->cimkeTagsag as $v) {
                        $a = $this->Sql->get($v->cimke_id, "termek_cimkek", 'id');
                        $arr[] = $a->nev;
                    }
                $cimkek = '"' . implode(",", $arr) . '";';
                print $cimkek;
                $push['cimkek'] = implode(",", $arr) ;
                
                
                $t->vannakValtozatok();

                $arr = array();
                if (!empty($t->valtozatok))
                    foreach ($t->valtozatok as $v) {
                        $arr[] = $v->nev;
                    }
                print '"' . implode(",", $arr) . '";';
                $push['valtozatnevek'] = implode(",", $arr);

                $arr = array();
                if (!empty($t->valtozatok))
                    foreach ($t->valtozatok as $v) {
                        $arr[] = $v->nev . ':' . $t->elerhetoKeszlet($v->id) . 'db';
                    }
                print '"' . implode(",", $arr) . '";';
                $push['valtozat_darabszamok'] = implode(",", $arr);

                $t->kepBetoltes();


                $arr = array();

                if (!empty($t->kepek))
                    foreach ($t->kepek as $v) {

                        $arr[] = $v->file;
                    }
                print '"' . implode(",", $arr) . '";';
                $push['kepek'] =  implode(",", $arr);
                 
                print '"' . $t->termekcsoport->nev . '";';
                $push['kepek'] =  $t->termekcsoport->nev;
    
                $str = $this->Sql->get($t->id, 'termek_kereso_hu', 'id');

                print '"' . htmlspecialchars($str->keresostr) . '";';
                $push['keresostr'] =  ($str)?$str->keresostr:'';
    



                $t->jellemzoBetoltes();

                $mezoKulcs = 'tulajdonsagnev_';
                $mezoErtek = 'tulajdonsagertek_';
                $i = 0;
                $arr = array();
                if (!empty($t->jellemzok))
                    foreach ($t->jellemzok as $k => $jellemzo) {

                        $felirat = $t->jellemzoFeliratTermelap($jellemzo->nev);
                        print '"' . htmlspecialchars(strip_tags($t->jellemzo($jellemzo->nev))) . '";';
                        
                        $push[$mezoKulcs.$i] = $felirat;
                        $push[$mezoErtek.$i] = htmlspecialchars(strip_tags($t->jellemzo($jellemzo->nev)));
                        
                        
                        $i++;
                        //$adat = str_replace('"','',trim(preg_replace('/\s\s+/', ' ', $v->adat['hu'])));
                        //print  '"'.strip_tags($adat).'";';
                    }

                $this->Sql->sqlSave($push, $tnev);

                print "\n";
            }

            $o = ob_get_contents();
            ob_end_clean();

            $nev = 'termekek_' . strToUrl($csoport->nev);

            var_dump(file_put_contents(ROOTPATH . 'data/' . $nev . '.csv', $o));
            print 'data/' . $nev . '.csv kiirva <br>';
            
             
            
        }
        print '<br>';
        print_r($osszesId);
    }

    public function heti() {

        for ($i = 30; $i--; $i > 0) {
            $ido = date('Y-m-d', strtotime("-$i weeks"));
            $ido2 = date('Y-m-d', strtotime("-" . ($i + 1) . " weeks"));

            $sql = "SELECT * FROM `naplobejegyzesek` WHERE `uzenet` LIKE 'termek/szerkesztes/0' AND "
                    . " ( ido >= '$ido2' AND ido < '$ido' )"
                    . "ORDER BY ido ASC ";
            $rs = $this->Sql->sqlSorok($sql);

            Print ($ido2 . ";" . $ido . ";" . count($rs)) . '<br>';
        }
    }

    public function heti2() {

        for ($i = 30; $i--; $i > 0) {
            $ido = date('Y-m-d', strtotime("-$i weeks"));
            $ido2 = date('Y-m-d', strtotime("-" . ($i + 1) . " weeks"));

            $sql = "SELECT * FROM `termekek`  "
                    . "WHERE  ( letrehozva >= '$ido2' AND letrehozva < '$ido' )"
                    . "";
            $rs = $this->Sql->sqlSorok($sql);

            Print ($ido2 . ";" . $ido . ";" . count($rs)) . '<br>';
        }
    }

}
