<div class="title">
	<div class="button float-right">
		<a href="character_edit.php" class="btn ui-state-default"><span class="ui-icon ui-icon-circle-plus"></span>新增角色</a>
	</div>
	<h3>角色管理</h3>
</div>
<div class="hastable">
	<form name="myform" class="pager-form" method="post" action="">
		<table id="sort-table"> 
		<thead> 
		<tr>
			<th><input type="checkbox" value="check_none" onclick="this.value=check(this.form.list)" class="submit"/></th>
		    <th>Name</th> 
		    <th>Title</th> 
		    <th>Type</th> 
			<th style="width:76px">Options</th> 
		</tr> 
		</thead> 
		<tbody>
		<? foreach($this->character as $char){?>
		<tr>
			<td class="center"><input type="checkbox" value="1" name="list" class="checkbox"/></td> 
		    <td><?=$char['name'];?></td> 
		    <td><?=$char['title'];?></td> 
		    <td><?=$char['type'];?></td> 
		    <td>
				<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Edit this character" href="#">
					<span class="ui-icon ui-icon-wrench"></span>
				</a>
				<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Delete this character" href="#">
					<span class="ui-icon ui-icon-circle-close"></span>
				</a>
			</td>
		</tr>
		<? }?>
		</tbody>
		</table>
	</form>
	<?php include($this->getLayoutPath() . '/pagebar.php'); ?>
</div>
<div class="clearfix"></div>