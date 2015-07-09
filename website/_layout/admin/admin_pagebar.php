<ul class="pagination float-right">
	<a class="btn_no_text btn ui-state-default ui-corner-all first" title="First Page" href="<?=$this->pagebar['first'];?>">
		<span class="ui-icon ui-icon-arrowthickstop-1-w"></span>
	</a>
	<a class="btn_no_text btn ui-state-default ui-corner-all prev" title="Previous Page" href="<?=$this->pagebar['prev'];?>">
		<span class="ui-icon ui-icon-circle-arrow-w"></span>
	</a>
    
    <? 
	foreach($this->pagebar['loop'] as $page){
		if($page['current']){
	?>
	<li class="active"><?=$page['num'];?></li>
	<?  }else{?>
    <li><a href="<?=$page['url'];?>"><?=$page['num'];?></a></li>
    	<? }?>
    <? }?>
	
	<a class="btn_no_text btn ui-state-default ui-corner-all next" title="Next Page" href="<?=$this->pagebar['next'];?>">
		<span class="ui-icon ui-icon-circle-arrow-e"></span>
	</a>
	<a class="btn_no_text btn ui-state-default ui-corner-all last" title="Last Page" href="<?=$this->pagebar['last'];?>">
		<span class="ui-icon ui-icon-arrowthickstop-1-e"></span>
	</a>
</ul>