<?php

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\\
 //+ $IMAGE :  image pointer from function ImageCreate() +\\
 //+ $RGB_CODE :  text value   "R,G,B"   example:  GREEN is "0,255,0"   +\\
function COLOR($IMAGE,$RGB_CODE)              //+ This function exports a color pointer with specified color code +\\
 { 
   $P_ARRAY = array();
   $tok = strtok($RGB_CODE,",");
   while ($tok)
    {
      $P_ARRAY[] = intval(trim($tok));
      $tok = strtok(",");
    }
  return ImageColorAllocate($IMAGE,intval($P_ARRAY[0]),intval($P_ARRAY[1]),intval($P_ARRAY[2]));
 }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\\

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\\

 function DRAW_ARC($IMAGE,$SX,$SY,$R,$START_ALPHA,$ALPHA,$RGB_CODE,$INNER_HOLE)
 {  //+This function draws sector with specified center, radius, angle, color +\\
   $pole = array();
   $tok = strtok($RGB_CODE,",");
   while ($tok)
    { $COLOR_ARRAY[] = intval(trim($tok));
      $tok = strtok(",");   }
   $COLOR = ImageColorAllocate($IMAGE,intval($COLOR_ARRAY[0]),intval($COLOR_ARRAY[1]),intval($COLOR_ARRAY[2]));
    for ($i = 0; $i <= $R-$INNER_HOLE; $i++)
     {  //+ Here draw I arc in style:          +  ))))))))       +\\
       ImageArc($IMAGE,$SX,$SY,$R-$i+1,$R-$i,$START_ALPHA,$ALPHA,$COLOR);
     }
 }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\\

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\\
function COOKIE_GRAPH($IMAGE,$EXPORT_INTO_FILE,$GRAPH_WIDTH,$GRAPH_HEIGHT,$LEGEND_BLOCK_LEFT, $LEGEND_BLOCK_TOP,
                                                 $VALUE_ARRAY,$NAME_ARRAY, $COLOR_ARRAY,$SX, $SY, $R,$HOLE,$GRAPH_HEADING_TEXT)
 {
  if (trim($EXPORT_INTO_FILE) == "")   {   Header("Content-Type: image/gif");   }  

  $IMAGE = ImageCreate($GRAPH_WIDTH,$GRAPH_HEIGHT);

  $white = COLOR($IMAGE,"255,255,255");
  $orange = COLOR($IMAGE,"220,210,60");
  $black = COLOR($IMAGE,"0,0,0");
  $blue = COLOR($IMAGE,"10,10,200");
  $red = COLOR($IMAGE,"255,0,0");
  $COLOR_VALUE = COLOR($IMAGE,"0,0,0");
  $gray = COLOR($IMAGE,"245,245,245");

  //+ Graph heading is centered over the workplace +\\  
  $px = (imagesx($IMAGE) - 8.5 * strlen($GRAPH_HEADING_TEXT))/2;
  ImageString($IMAGE,5,$px,8,$GRAPH_HEADING_TEXT,$red);
  // + Scaling 360° and values +\\
  $VALUE_SUM = 0;
  for ($i=0; $i < sizeof($VALUE_ARRAY);$i++)
       {  $VALUE_SUM = intval($VALUE_SUM) + intval($VALUE_ARRAY[$i]);	 }
   // + Scaling ration +\\
  $KOEF = 360 / $VALUE_SUM;

  $START_ALPHA = 0;
  $ALPHA = 0;
  for ($i=0; $i < sizeof($VALUE_ARRAY);$i++)
   {
     $ALPHA = $START_ALPHA + ($KOEF * $VALUE_ARRAY[$i]);	 //+ Start and end angle +\\
	 //+ call function -> draw arc centered in (RSX,RSY), radius $R,ANGLE,COLOR and inner HOLE +\\
     DRAW_ARC($IMAGE,$SX, $SY, $R, $START_ALPHA, $ALPHA, $COLOR_ARRAY[$i], $HOLE);
     $START_ALPHA = $ALPHA;
	 //+ Small rectangle with specified color in legend +\\
     ImageFilledRectangle($IMAGE,$LEGEND_BLOCK_LEFT,
                                                       $LEGEND_BLOCK_TOP +2+$i*16,
                                                       $LEGEND_BLOCK_LEFT+15,
                                                       $LEGEND_BLOCK_TOP+10+$i*16,
                                                       COLOR($IMAGE,$COLOR_ARRAY[$i]));

    $RATIO = $VALUE_ARRAY[$i] / $VALUE_SUM * 100;      
	 //+ Write value of size and its ratio +\\
     ImageString($IMAGE,2,
                                     $LEGEND_BLOCK_LEFT + 20,
                                     $LEGEND_BLOCK_TOP + $i*16,
                                      substr(trim($RATIO),0,strpos(trim($RATIO),".")+intval(3))." %",
                                     $black);      
	 //+ Write name of specified sector +\\
     ImageString($IMAGE,3,
                                     $LEGEND_BLOCK_LEFT + 70,
                                     $LEGEND_BLOCK_TOP + $i*16,
                                     $NAME_ARRAY[$i],
                                     $black);      
  }
  //+ If the filename not exists then draw Gif image else export Gif image into file  +\\
   if (trim($EXPORT_INTO_FILE) == "") { ImageGif($IMAGE); }
    else { ImageGif($IMAGE,$EXPORT_INTO_FILE); }
   ImageDestroy($IMAGE);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\\

// -------- EXAMPLE --------\\

if ( trim($POSITION) == ""  )
 {
    echo "<HTML>\n"; 
    echo "<BODY>\n";
    echo "<FORM METHOD=\"POST\" ACTION=\"".$SCRIPT_NAME."\">\n";
    echo "<table align=\"center\" bgcolor=\"#ECECEC\" width=\"400\" colspacing=\"1\" cellpadding=\"1\" border=\"0\">\n";
    echo "<TR>\n";
    echo "<TD COLSPAN=\"3\" ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">GRAPH NAME:</font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"GRAPH_HEADING_TEXT\" SIZE=30 MAXWIDTH=30 VALUE=\"TEST THIS GRAPH\">";
    echo "</TD>\n";	
    echo "</TR>\n";	
    echo "<TR>\n";
    echo "<TD COLSPAN=\"2\" ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">CENTER X - AXIS: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"SX\" SIZE=3 MAXWIDTH=3 VALUE=\"80\">";
    echo "</TD>\n";	
    echo "<TD  ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">OUTER RADIUS: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"R\" SIZE=2 MAXWIDTH=2 VALUE=\"150\">";
    echo "</TD>\n";	
    echo "</TR>\n";	

    echo "<TR>\n";
    echo "<TD COLSPAN=\"2\" ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">CENTER Y - AXIS: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"SY\" SIZE=3 MAXWIDTH=3 VALUE=\"120\">";
    echo "</TD>\n";	
    echo "<TD  ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">INNER RADIUS: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"HOLE\" SIZE=2 MAXWIDTH=2 VALUE=\"30\">";
    echo "</TD>\n";	
    echo "</TR>\n";	

    echo "<TR>\n";
    echo "<TD COLSPAN=\"2\" ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">GRAPH_WIDTH: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"GRAPH_WIDTH\" SIZE=3 MAXWIDTH=3 VALUE=\"360\">";
    echo "</TD>\n";	
    echo "<TD  ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">GRAPH_HEIGHT: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"GRAPH_HEIGHT\" SIZE=2 MAXWIDTH=2 VALUE=\"200\">";
    echo "</TD>\n";	
    echo "</TR>\n";	

    echo "<TR>\n";
    echo "<TD COLSPAN=\"2\" ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">LEGEND_BLOCK_LEFT: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"LEGEND_BLOCK_LEFT\" SIZE=3 MAXWIDTH=3 VALUE=\"180\">";
    echo "</TD>\n";	
    echo "<TD  ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">LEGEND_BLOCK_TOP: </font>";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"LEGEND_BLOCK_TOP\" SIZE=2 MAXWIDTH=2 VALUE=\"60\">";
    echo "</TD>\n";	
    echo "</TR>\n";	

    echo "<TR>\n";
    echo "<TD  ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">NAME</font></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">VALUE</font></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><font face=\"Arial\" size=\"2\">COLOR</font></TD>\n";		
    echo "</TR>\n";	
    echo "<TR>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"NAME_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"Worker 1\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"VALUE_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"150\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"COLOR_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"25,130,140\"></TD>\n";		
    echo "</TR>\n";	
    echo "<TR>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"NAME_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"Worker 2\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"VALUE_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"360\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"COLOR_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"50,30,140\"></TD>\n";		
    echo "</TR>\n";	
    echo "<TR>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"NAME_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"Worker 3\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"VALUE_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"240\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"COLOR_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"250,30,240\"></TD>\n";		
    echo "</TR>\n";	
    echo "<TR>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"NAME_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"Worker 4\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"VALUE_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"120\"></TD>\n";
    echo "<TD  ALIGN=\"CENTER\"><INPUT TYPE=\"TEXT\" NAME=\"COLOR_ARRAY[]\" SIZE=15 MAXWIDTH=15 VALUE=\"50,130,240\"></TD>\n";		
    echo "</TR>\n";	

    echo "<TR>\n";
    echo "<TD COLSPAN=\"3\" ALIGN=\"CENTER\">\n";
	echo "<INPUT TYPE=\"SUBMIT\"  VALUE=\"Draw graph !\" >\n";
	echo "<INPUT TYPE=\"HIDDEN\" NAME=\"POSITION\" VALUE=\"DRAW\" >\n";	
    echo "</TD>\n";	
    echo "</TR>\n";		
	
    echo "</TABLE>\n";
    echo "</FORM>\n";
    echo "</BODY>\n";
    echo "</HTML>\n";
 }
else
 {
/*
   $VALUE_ARRAY = array(100,100,100,100,100,100);
   $NAME_ARRAY = array("1. worker","2. worker","3. worker","4. worker","5. worker","6. worker");
   $COLOR_ARRAY = array("100,190,60","150,200,130","110,150,230","140,120,80","210,0,0","140,230,210");
   $GRAPH_WIDTH = 400;
   $GRAPH_HEIGHT = 300;
   $SX = 120;   // X- center \\
   $SY = 140;   // Y- center \\
   
   $R = 180;    // Radius  \\
   $LEGEND_BLOCK_LEFT = 240;
   $LEGEND_BLOCK_TOP = 70; 
   $HOLE = 0;
   $GRAPH_HEADING_TEXT = "Test the best (worker)";
*/   
   COOKIE_GRAPH($im,"",$GRAPH_WIDTH,$GRAPH_HEIGHT,$LEGEND_BLOCK_LEFT, $LEGEND_BLOCK_TOP,
                                    $VALUE_ARRAY,$NAME_ARRAY, $COLOR_ARRAY,$SX, $SY, $R, $HOLE,$GRAPH_HEADING_TEXT);
}

?>