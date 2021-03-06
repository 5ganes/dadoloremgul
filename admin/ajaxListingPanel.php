<?php
include("init.php");
?>
<style type="text/css">
  .listShortDescription{width: 660px; height: 90px; padding: 5px;}
</style>
<div>
  <?php
  $listResult = $groups->getById($_GET['listId']);
  $listRow = $conn->fetchArray($listResult);                
  
  $weight = $groups -> getSubLastWeight($_GET['id'], "ListSub");
  if($listRow['weight'] > 0)
    $weight = $listRow['weight'];
    
  if (!empty($listRow['id']))
  {
  ?>
  <input type="hidden" name="listId" value="<?php echo $listRow['id']; ?>" />
  <?php
  }
  ?>
  <span>Date : </span> <span>
  <?php
  if (empty($listRow['onDate']))
    echo date('d M Y');
  else
  {
    $dateArr = explode("-", $listRow['onDate']);
    echo date('d M Y', mktime(0,0,0, $dateArr[1], $dateArr[2], $dateArr[0]));
  }
  ?>
  </span> <br class="clearboth" />

  <!-- <span style="padding-right:23px;">Page Title : </span> <span>
  <input style="margin: 2px" type="text" name="listPageTitle" value="<?php echo $listRow['pageTitle']; ?>" class="text" />
  </span> <br class="clearboth" />
  <span style="padding-right:1px;">Page Keyword : </span> <span>
  <input type="text" style="margin: 2px; margin-left: 4px;" name="listPageKeyword" value="<?php echo $listRow['pageKeyword']; ?>" class="text" /> -->

  </span> <br class="clearboth" />
  <span style="padding-right:50px;">Title : </span> <span>
  <input type="text" style="margin: 2px" name="listTitle" id="listTitle" value="<?php echo $listRow['name']; ?>" class="text" onchange="copySame('listUrlTitle', this.value);" /></span>
  <br class="clearboth" />
  <span style="padding-right:25px;">Alias Title : </span> <span>
  <input type="text" style="margin: 2px; margin-left: 0" name="listUrlTitle" id="listUrlTitle" value="<?php echo $listRow['urlname']; ?>" class="text" onchange="copySame('listUrlTitle', this.value);" />
  </span> <br class="clearboth" />
  <div>Short Description : </div> <span>
  <textarea class="listShortDescription" name="listShortDescription"><?php echo $listRow['shortcontents']; ?></textarea>
  </span> <br class="clearboth" />
  <span>Description : </span> <span>
    
  <textarea id="listDescription" name="listDescription"><?=$listRow['contents'];?></textarea>
  <script type="text/javascript">
    CKEDITOR.replace( 'listDescription' );
  </script>

  </span> <br class="clearboth" />
  <?php if(isset($_GET['listId']) && file_exists("../" . CMS_GROUPS_DIR . $listRow['image']) && !empty($listRow['image'])){ ?>
  <span>Existing Image : </span>
  <span><img src="../<?php echo CMS_GROUPS_DIR . $listRow['image']; ?>" width="75" /> [<a href="manage_cms.php?id=<?php echo $_GET['id']; ?>&parentId=<?php echo $_GET['parentId']; ?>&groupType=<?php echo $_GET['groupType']; ?>&listId=<?php echo $_GET['listId']; ?>&deleteImage<?php if(isset($_GET['page'])) echo '&page='. $_GET['page']; ?>">Delete</a>]</span>
  <br class="clearboth" />
  <?php } ?>
  <p style="margin: 0"><span style="padding-right:30px;">Image : </span> <span>
  <input type="file" name="listImage" class="file" />
  </span></p>
  <p style="margin: 5px 0 0"><span style="padding-right:16px;">Featured : </span> <span>
  <select name="listMain" class="list1">
    <option value="no" selected>No</option>
    <option value="yes"<?php if($listRow['featured'] == "yes") echo ' selected'; ?>>Yes</option>    
  </select>  
  </span></p>
  <p style="margin: 5px 0 0"><span style="padding-right:26px;">Weight : </span> <span>
  <input type="text" name="listWeight" value="<?php echo $weight; ?>" class="text" style="width:30px;" />  
  </span></p>
  <hr style="clear: both;">
  <div align="right" style="cursor: pointer;" onclick="addListFile();">+ Add Attachment +</div>
  <br>
  <style>
  .sno
  {
    float:left; width:50px;
  }
  
  .filename
  {
    float:left; width:200px; 
  }
  
  .size
  {
    float:left; width:100px;
  }
  
  .caption
  {
    float:left; width:280px;
  }
  
  .action
  {
    float:left; 
  }
  
  .strng
  {
    font-weight:bold;
  }
  </style>
  <div>
    <div class="sno strng">S.no</div>
    <div class="filename strng">Filename</div>
    <div class="size strng">Size</div>
    <div class="caption strng">Caption</div>
    <div class="action strng">Action</div>
    <br style="clear: both;">
    <?php
    $counter = 0;
    $lfResult = $listingFiles->getByListingId($_GET['listId']);
    while ($lfRow = $conn->fetchArray($lfResult))
    {
    ?>
    <div class="sno"> <?php echo ++$counter;?> </div>
    <div class="filename"> <?php echo $lfRow['filename'];?> </div>
    <div class="size"> <?php echo round(filesize("../" . CMS_LISTING_FILES_DIR . $lfRow['filename'])/1024,0);?> kb</div>
    <div class="caption"> <?php echo $lfRow['caption'];?>&nbsp; </div>
    <div class="action"> <a href="#" onclick="delete_confirmation('manage_cms.php?id=<?php echo $_GET['id']; ?>&parentId=<?php echo $_GET['parentId']; ?>&groupType=<?php echo $_GET['groupType']; ?>&listId=<?php echo $_GET['listId'];?>&fileId=<?php echo $lfRow['id']; ?>&deleteFile<?php if(isset($_GET['page'])) echo '&page='. $_GET['page']; ?>')"> Delete </a> </div>
    <br style="clear: both;">
    <?php
    }
    ?>
    <br style="clear: both;">
    <br style="clear: both;">
  </div>
  <div id="uploadFileHolder">
    <div style="width:100px; float: left;">File : </div>
    <div style="float:left; margin-bottom: 5px;">
      <input type="file" name="listFile[]" class="file" />
    </div>
    <br style="clear: both;">
    <div style="width:100px; float: left;">Caption : </div>
    <div style="float:left; margin-bottom: 5px;">
      <input type="text" name="listCaption[]" class="text" />
    </div>
    <hr style="clear: both;">
  </div>
</div>
<?php
if (isset($_GET['id']))
{
?>
<div>
  <h2>Listings</h2>
  <hr noshade="noshade" />
</div>
<div> <!-- style="height: 300px; overflow: scroll;" -->
  <table width="100%">
    <tr>
      <td valign="top">S.no</td>
      <td valign="top">Image</td>
      <td valign="top">Title</td>
      <td valign="top">Main</td>
      <td valign="top">Attachments</td>
      <td valign="top">Date</td>
      <td valign="top">Action</td>
    </tr>
    <?php
    $counter = 0;
    $pagename = "cms.php?id=" . $_GET['id'] . "&parentId=" . $_GET['parentId'] . "&groupType=" . urlencode($_GET['groupType']) . "&";   

    $sql = "SELECT * FROM groups WHERE parentId = '". $_GET['id'] . "' ORDER BY weight DESC, id DESC";

    include("../includes/paging.php");
    
    $listResult = $result;
    
    //$listResult = $listings->getByGroupId($_GET['id']);
    while ($listRow = $conn->fetchArray($listResult))
    {
    $counter++;
    ?>
    <tr>
      <td valign="top"><?php echo $start + $counter; ?></td>
      <td  valign="top"><?php if(!empty($listRow['id']) && file_exists("../".CMS_GROUPS_DIR . $listRow['image']) && !empty($listRow['image'])){ ?>
        <img src="../data/imager.php?file=../<?php echo CMS_GROUPS_DIR . $listRow['image'] ?>&mw=50&mh=50&fix" border="0" />
        <?php } ?>
      </td>
      <td valign="top"><?php echo $listRow['name']; ?> </td>
      <td valign="top"><?php echo ucfirst($listRow['featured']); ?></td>
      <td valign="top"><?php echo $listingFiles->getTotalAttachmentsByListingId($listRow['id']); ?></td>
      <td valign="top"><?php echo $listRow['onDate']; ?></td>
      <td valign="top"><a href="cms.php?id=<?php echo $_GET['id'] ?>&parentId=<?php echo $_GET['parentId']; ?>&groupType=<?php echo $_GET['groupType']; ?>&listId=<?php echo $listRow['id'] ?><?php if(isset($_GET['page'])) echo '&page='. $_GET['page']; ?>">Edit</a> / <a href="#" onclick="delete_confirmation('manage_cms.php?id=<?php echo $_GET['id'] ?>&parentId=<?php echo $_GET['parentId']; ?>&groupType=<?php echo $_GET['groupType']; ?>&deleteListId=<?php echo $listRow['id'] ?><?php if(isset($_GET['page'])) echo '&page='. $_GET['page']; ?>');">Delete</a> </td>
    </tr>
    <tr>
      <td colspan="7" height="1px" style="border-bottom: 1px solid;"></td>
    </tr>
    <?php
    }
    ?>
    <tr>
      <td colspan="7"><?php include("../includes/paging_show.php"); ?></td>
    </tr>
  </table>
</div>
<hr noshade="noshade">
<?php
}
?>
