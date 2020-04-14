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
            
            foreach ($prodi as $prodi_list){
                $pdf->AddPage();
                $no=0;
                $html='
                <table border=0 width="100%">
                    <tr>
                        <td><font size="12"><strong> '.$tentangsk.'</strong></font><hr></td>
                    </tr>
                    <tr>
                        <td><font size="14">'.strtoupper($this->prodi->get_fakultasname_by_prodiname($prodi_list->namaprodi)->namafakultas).'</font></td>
                    </tr>
                    <tr>
                        <td><font size="14">PROGRAM STUDI '.strtoupper($prodi_list->namaprodi).'</font></td>
                    </tr>
                    <tr>
                        <td><font size="14">JENJANG '.strtoupper($prodi_list->jenjang).'</font></td>
                    </tr>
                </table>
                <div></div>
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
                $html.='</table><div></div>
                <table width="100%">
                    <tr>
                        <td width="60%"></td>
                        <td align="left" width="40%">Manokwari, '.date_indo(date('Y-m-d')).'</td>
                    </tr>
                    <tr>
                        <td width="60%"></td>
                        <td align="left" width="40%">Menyetujui,</td>
                    </tr>
                    <tr>
                        <td width="60%"></td>
                        <td align="left" width="40%">Dekan '.$this->prodi->get_fakultasname_by_prodiname($prodi_list->namaprodi)->namafakultas.'</td>
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
                        <td width="60%"></td>
                        <td align="left" width="40%">'.$this->prodi->get_fakultasname_by_prodiname($prodi_list->namaprodi)->namadekan.'</td>
                    </tr>
                </table>';
                $pdf->writeHTML($html, true, false, true, false, '');
            };

			$pdf->Output($tentangsk.'.pdf', 'I');
?>
                        