<ul class="pagination">
	<? if($this->pagebar['current'] > 1){ ?>
		<li class="previous"><a href="<?=$this->pagebar['prev'];?>" class="previous-off">&laquo;</a></li>
	<? }else{ ?>
		<li class="previous-off">&laquo;</li>
	<? }?>

    <? 
	foreach($this->pagebar['loop'] as $page){
		if($page['current']){
	?>
			<li class="active"><?=$page['num'];?></li>
	<?  }else{	?>
			<li><a href="<?=$page['url'];?>"><?=$page['num'];?></a></li>
    <?
		}
	}
	?>
    
	<? if($this->pagebar['current'] < $this->pagebar['pageCount']){ ?>
		<li class="next"><a href="<?=$this->pagebar['next'];?>">&raquo;</a></li>
	<? }else{ ?>
		<li class="next-off">&raquo;</li>
	<? }?>
	<div class="clearfix"></div>
</ul>