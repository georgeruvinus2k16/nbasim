<script>
</script>
<body>
<?php
     $burg=$this->session->userdata('draftees');
     foreach($burg as $g){
         echo $g." ";
     }
     echo "</br>";
     for($d=0;$d<count($burg);$d++){
         echo $burg[$d]." ";
     }
 ?>