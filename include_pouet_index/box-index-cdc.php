<?php
class PouetBoxIndexCDC extends PouetBoxCachable {
  var $data;
  var $prod;
  function __construct() {
    parent::__construct();
    $this->uniqueID = "pouetbox_cdc";
    $this->title = "coup de coeur";
  }

  function LoadFromCachedData($data) {
    $this->data = unserialize($data);
  }

  function GetCacheableData() {
    return serialize($this->data);
  }

  function LoadFromDB() {
    $s = new BM_Query();
    $s->AddTable("cdc");
    $s->attach(array("cdc"=>"which"),array("prods as prod"=>"id"));
    $s->AddOrder("cdc.addedDate desc");
    $s->SetLimit(1);
    list($this->data) = $s->perform();

    $a = array(&$this->data->prod);
    PouetCollectPlatforms($a);
  }

  function RenderContent() {
    //return $this->prod->RenderLink() . " $ " . $this->prod->RenderGroupsShort();
    if ($this->data && $this->data->prod)
      $this->data->prod->RenderAsEntry();
  }
  function RenderFooter() {
    echo "  <div class='foot'><a href='awards.php'>awards</a> :: <a href='cdc.php'>more</a>...</div>\n";
    echo "</div>\n";
    return $s;
  }
};

$indexAvailableBoxes[] = "CDC";
?>