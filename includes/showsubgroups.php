<style>
	.download{width:430px;}
	.download ul{ margin:0;}
	.download ul li{ list-style:none;}
</style>	
<?php //include("includes/breadcrumb.php"); ?>
<div class="main-content" style="width:100%; font-size:12px;text-align:justify">
<h1 class="pagetitle"><?php echo $pageName; ?></h1>
<div class="content">
<?php
$pagename = "index.php?id=". $pageId ."&";
include("includes/pagination.php");

echo Pagination($pageContents, "content");?>
<br /><br>
<?
	if($pageId==338 or $pageId==341)
	{
		echo '<div class="download"><h3>प्रकाशनहरु डाउनलोड गर्नुहोस</h3></<ul>';
		$down=$groups->getByParentId($pageId);
		while($downRow=$conn->fetchArray($down))
		{?>
			<li>
            	<div style="float: left;width: 330px;"><?=$downRow['name'];?></div>
            	<div style="float:right;">
                	<a href="<?=CMS_FILES_DIR.$downRow['contents'];?>"><img src="img/pdf.png" width="23" /></a>
             	</div>
            	<div style="clear:both"></div>
			</li>
		<? }
		echo '</ul></div>';
	}
?>


</div>
</div>