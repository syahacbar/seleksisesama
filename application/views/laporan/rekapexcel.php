<?php 
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0"); 
 ?>
 <table border="0" width="100%" style="font-size:19;font-weight:bold;">
    <tr><th colspan="7"><?php echo $title;?></th></tr>
    <tr><td></td></tr>
 </table>
 <table border="1" width="100%">
      <thead>
                <tr height="40" bgcolor="gray">
                    <th width="20px">No</th>
                    <th>Program Studi</th>
                    <th>Peminat</th>
                    <th>Daya Tampung</th>
                    <th>Terima</th>
                    <th>Kosong</th>
                    <th>% Kosong</th>
                </tr>
      </thead>
      <tbody>
           <?php $i=1; foreach($list as $row) { ?>
           <tr style="text-align:center;"  height="20">
                <td style="text-align:right;"><?php echo $i; ?></td>
                <td style="text-align:left;"><?php echo $row->namaprodi; ?></td>
                <td><?php echo $row->peminat; ?></td>
                <td><?php echo $row->dayatampung; ?></td>
                <td><?php echo $row->terima; ?></td>
                <td><?php echo $row->kosong; ?></td>
                <td><?php echo $row->persenkosong*100; echo " %"; ?></td>
           </tr>
           <?php $i++; } ?>
      </tbody>
      <tfoot>
                <tr height="40" bgcolor="gray">
                    <th colspan="2">Total</th>
                    <th><?=$totalpeminat;?></th>
                    <th><?=$totaldayatampung;?></th>
                    <th><?=$totalterima;?></th>
                    <th><?=$totalkosong;?></th>
                    <th><?=$persenkosong; echo " %";?></th>
                </tr>
      </tfoot>
 </table>