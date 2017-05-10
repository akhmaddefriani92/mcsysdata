<?php
if($_POST['btn-upload'] == "Upload")
{
   $nama_berkas = $_FILES['berkas']['name'];
   $tipe_berkas = $_FILES['berkas']['type'];
   $ukuran_berkas = $_FILES['berkas']['size'];
                                         
     if($nama_berkas != "")
     {
      $sumber = $_FILES['berkas']['tmp_name'];
      $target = "csv/$nama_berkas";
       if(move_uploaded_file($sumber,$target))
       {
         echo "<b>Nama File :</b> $nama_berkas";
         echo "<br/><b>Tipe File :</b> $tipe_berkas";
         echo "<br/><b>Ukuran File :</b> $ukuran_berkas bytes";
         echo "<br/> Telah berhasil diupload !!!";
       }
       else{
         echo $_FILES['berkas']['error'];
       }
     }

}
?>
 <form  method="post" enctype="multipart/form-data">
 <b>File :</b> <input type="file" name="berkas" />
  <input type="submit" name="btn-upload" value="Upload" />
 </form>
                                                                                   
