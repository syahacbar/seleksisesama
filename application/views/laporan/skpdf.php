<?php
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Seleksi Lokal Universitas Papua');
            
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
			$pdf->SetHeaderMargin(30);
			$pdf->SetTopMargin(20);
			$pdf->setFooterMargin(20);
			//$pdf->SetAutoPageBreak(true);
			$pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->AddPage();
            $html='
            <table border=0 width="100%">
                <tr>
                    <td width="15%"><font size="12">LAMPIRAN</font></td>
                    <td width="85%"><font size="12">: '.$lampiransk.'</font></td>
                </tr>
                <tr>
                    <td><font size="12">NOMOR</font></td>
                    <td><font size="12">: '.$nomorsk.'</font></td>
                </tr>
                <tr>
                    <td><font size="12">TENTANG</font></td>
                    <td><font size="12">: '.$tentangsk.'</font></td>
                </tr>
            </table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            foreach ($fakultas as $fakultas_list){
                $html ='
                    <table border=0 width="100%">
                        <tr>
                            <td><font size="14"><strong>'.strtoupper($fakultas_list->namafakultas).'</strong></font></td>
                        </tr>
                    </table>';
                foreach ($this->laporan->prodi_array($fakultas_list->idfakultas) as $prodi_list){
                    $no=0;
                    $html.='<table>
                        <tr>
                            <td><font size="12">PROGRAM STUDI '.strtoupper($prodi_list->namaprodi).'</font></td>
                        </tr>
                        <tr>
                            <td><font size="12">JENJANG '.strtoupper($prodi_list->jenjang).'</font></td>
                        </tr>
                        <tr><td></td></tr>
                    </table>
                            <table cellspacing="1" bgcolor="#666666" cellpadding="2">
                                <tr bgcolor="##a4a1a1">
                                    <th width="5%" align="center"><strong>NO</strong></th>
                                    <th width="20%" align="center"><strong>NO. PESERTA</strong></th>
                                    <th width="55%" align="center"><strong>NAMA</strong></th>
                                    <th width="20%" align="center"><strong>SUKU</strong></th>
                                </tr>';
                    foreach ($this->laporan->skpdf($prodi_list->namaprodi) as $row) 
                        {
                            $no++;
                            if($no%2){
                            $html.='<tr bgcolor="#FFFFFF">
                                    <td align="center">'.$no.'</td>
                                    <td align="center">'.$row->nopendaftar.'</td>
                                    <td>'.strtoupper($row->namapendaftar).'</td>
                                    <td align="center">'.strtoupper($row->suku).'</td>
                                </tr>';
                            } else {
                                $html.='<tr bgcolor="#c3bfbf">
                                    <td align="center">'.$no.'</td>
                                    <td align="center">'.$row->nopendaftar.'</td>
                                    <td>'.strtoupper($row->namapendaftar).'</td>
                                    <td align="center">'.strtoupper($row->suku).'</td>
                                </tr>';
                            }
                        }
                    $html.='</table><div></div>';
                    
                };
                $html.='<div></div>';
                $pdf->writeHTML($html, true, false, true, false, '');
            };
                $html ='<table width="100%">
                <tr>
                    <td width="65%"></td>
                    <td align="left" width="35%">Rektor,</td>
                </tr>
                <tr>
                    <td width="60%"></td>
                    <td align="left" width="40%"></td>
                </tr>
                <tr>
                    <td width="60%"></td>
                    <td align="left" width="40%"></td>
                </tr>
                <tr>
                    <td width="60%"></td>
                    <td align="left" width="40%"></td>
                </tr>
                <tr>
                    <td width="60%"></td>
                    <td align="left" width="40%"></td>
                </tr>
                <tr>
                    <td width="65%"></td>
                    <td align="left" width="35%"><u>'.$this->pengaturan->getnamarektor()->nilai.'</u></td>
                </tr>
                <tr>
                    <td width="65%"></td>
                    <td align="left" width="35%">NIP. '.$this->pengaturan->getniprektor()->nilai.'</td>
                </tr>
            </table>';
            
            $pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('LAMPIRAN SK '.$tentangsk.'.pdf', 'I');
?>
                        