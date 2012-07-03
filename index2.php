<?php
include ("common.php");

if($_SESSION['is_logged']===true)
{
    if(isset($_FILES['user_pic']))
	
    if($_FILES['user_pic']['tmp_name'])
    {
        if($_FILES['user_pic']['size']>2097152)
        {
            $err[]='Failat e nad  2MB';
        }
        if($_FILES['user_pic']['type']!='image/jpeg'  &&  $_FILES['user_pic']['type']!='image/gif'  &&  $_FILES['user_pic']['type']!='image/png' )
        {
            $err[]='Failat ne e snimka';
        }
       if(count($err)==0)
       {
           if ( !is_dir('pictures'))
           {
               mkdir('pictures', 0777);// suzdava Ob6ta papka
		
           }
		   if ( !is_dir('pictures'.'/'.'user_pics'.$_SESSION['user_id']))
           {
               mkdir('pictures'.'/'.'user_pics'.$_SESSION['user_id'], 0777);// suzdava individualni papki za vseki potrebitel vutre v ob6tata
		
           } 
		    $name=time().'_'.$_FILES['user_pic']['name'];
			
           if ( move_uploaded_file($_FILES['user_pic']['tmp_name'], 'pictures'.'/'.'user_pics'.$_SESSION['user_id'].'/'.$name)){
		   
               run_q('INSERT INTO pictures(pic_name, catalogue_id, comment, date_added) 
                   VALUES ("'.$name.'",'.(int)$_POST['folder'].', "'.addslashes($_POST['user_desc']).'",'.time().')');
				   
               create_thumb('pictures'.'/'.'user_pics'.$_SESSION['user_id'].'/'.$name);
               $success=true;
           }
           else
           {
               $err[]='Molia opitaite otnovo.';
           }
       }
    }
    $folders=fetch_all(run_q('SELECT * FROM catalogues WHERE user_id='.$_SESSION['user_id']));
    include("header.php");
    include("uploadd.php");
    include("footer.php");
}
else
{
header( ' Location: index.php ' );
exit;
}
function create_thumb($sourse, $thumb_width=100)
{

$fl = dirname($sourse);// Ot tuka nadolu elseif - ovete az si gi izmislih i rabotiat, no izska4at warningi
   $new_name=' thumb_ ' .basename($sourse);
   if ($img = imagecreatefromjpeg($sourse)){

   $width = imagesx($img);
   $height = imagesy($img);
   $new_width = $thumb_width;
   $new_height = floor($height * ( $thumb_width / $width ) );
   $tmp_img = imagecreatetruecolor($new_width, $new_height);
   imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
   imagejpeg($tmp_img, $fl.'/'.$new_name);
   
} elseif  ($img = imagecreatefromgif($sourse)){

   $width = imagesx($img);
   $height = imagesy($img);
   $new_width = $thumb_width;
   $new_height = floor($height * ( $thumb_width / $width ) );
   $tmp_img = imagecreatetruecolor($new_width, $new_height);
   imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
   imagegif($tmp_img, $fl.'/'.$new_name);
   
 } elseif  ($img = imagecreatefrompng($sourse)){

   $width = imagesx($img);
   $height = imagesy($img);
   $new_width = $thumb_width;
   $new_height = floor($height * ( $thumb_width / $width ) );
   $tmp_img = imagecreatetruecolor($new_width, $new_height);
   imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
   imagepng($tmp_img, $fl.'/'.$new_name);
 }
 }
?>

