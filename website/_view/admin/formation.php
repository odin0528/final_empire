<form action="arena.php" method="post" enctype="multipart/form-data" class="forms" name="form" >
<div class="page-title ui-widget-content ui-corner-all">
	<h1><b>兢技場隊伍設定</b></h1>
	<div class="other">
		<div class="float-left">設定戰鬥隊伍，進行模擬戰鬥</div>
		<div class="button float-right">
			<button type="submit" value="Submit" class="ui-state-default ui-corner-all" id="saveForm">開始戰鬥</button>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="two-column">
	<div class="column">
		<div class="portlet">
			<div class="portlet-header">進攻方</div>
			<div class="portlet-content">
				<? for($i = 1; $i <= 5; $i++){?>
				<ul>
					<li>
						<label  class="desc">
							<?=$i;?>. 角色 & 兵種：
						</label>
						<div>
							<select name="offensive[char_id][]" class="field medium">
								<option value="">無</option>
								<? foreach($this->character as $char){?>
								<option value="<?=$char['id'];?>"><?=$char['title'].$char['name'];?> - <?=$char['type'];?></option>
								<? }?>
							</select>
							<select name="offensive[army_id][]" class="field small">
							<? foreach($this->army as $army){?>
								<option value="<?=$army['id'];?>"><?=$army['name'];?></option>
							<? }?>
							</select>
						</div>
					</li>
					<li>
						<label  class="desc">
							等級：
						</label>
						<div>
							<input class="spinner" type="text" value="30" name="offensive[lv][]" />
						</div>
					</li>
				</ul>
				<div class="linetop clearfix"></div>
				<? }?>
			</div>
		</div>
	</div>
	
	<div class="column">
		<div class="portlet">
			<div class="portlet-header">防守方</div>
			<div class="portlet-content">
				<? for($i = 1; $i <= 5; $i++){?>
				<ul>
					<li>
						<label  class="desc">
							<?=$i;?>. 角色 & 兵種：
						</label>
						<div>
							<select name="defender[char_id][]" class="field medium">
								<option value="">無</option>
								<? foreach($this->character as $char){?>
								<option value="<?=$char['id'];?>"><?=$char['title'].$char['name'];?> - <?=$char['type'];?></option>
								<? }?>
							</select>
							<select name="defender[army_id][]" class="field small">
							<? foreach($this->army as $army){?>
								<option value="<?=$army['id'];?>"><?=$army['name'];?></option>
							<? }?>
							</select>
						</div>
					</li>
					<li>
						<label  class="desc">
							等級：
						</label>
						<div>
							<input class="spinner" type="text" value="30" name="defender[lv][]" />
						</div>
					</li>
				</ul>
				<div class="linetop clearfix"></div>
				<? }?>
			</div>
		</div>
	</div>
</div>
</form>