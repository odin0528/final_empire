<?php include('header.php'); ?>
	<div id="page-wrapper">
		<div id="main-wrapper">
			<div id="main-content">
				<div class="title">
					<h2>Three column setup</h2>
					These are differnt methods of showing titles.
				</div>
				<div class="three-column">
					<div class="column">
						<div class="portlet">
							<div class="portlet-header">Feeds</div>
							<div class="portlet-content">
								<form action="#" method="post" enctype="multipart/form-data" class="forms" name="form" >
									<ul>
										<li>
											<label  class="desc">
												Name ( input class="small" )
											</label>
											<div>
												<input type="text" tabindex="1" maxlength="255" value="" class="field text small" name="" />
											</div>
										</li>
										<li>
											<label  class="desc">
												Input ( input class="medium" )
											</label>
											<div>
												<input type="text" tabindex="1" maxlength="255" value="" class="field text medium" name="" />
											</div>
										</li>
										<li>
											<label  class="desc">
												Input ( input class="large" )
											</label>
											<div>
												<input type="text" tabindex="1" maxlength="255" value="" class="field text large" name="" />
											</div>
										</li>
										<li>
											<label  class="desc">
												Textarea  ( input class="small" )
											</label>
											<div>
												<textarea tabindex="2" cols="50" rows="5" class="field textarea small" name="" ></textarea>
											</div>
										</li>
										<li>
											<label  class="desc">
												Other
											</label>
											<div class="float-left">
												<span>
													<input type="text" tabindex="6" value="" class="field text" name="" />
													<label >Example</label>
												</span>
											</div>
											<div class="float-left">
												<span>
													<input type="text" tabindex="6" value="" class="field text" name="" />
													<label >Example</label>
												</span>
											</div>
											<div class="float-left">
												<span>
													<input type="text" tabindex="6" value="" class="field text" name="" />
													<label >Example</label>
												</span>
											</div>
											<div class="float-left">
												<span>
													<input type="text" tabindex="6" value="" class="field text" name="" />
													<label >Example</label>
												</span>
											</div>
										</li>
										<li>
											<label  class="desc">
												Priority
											</label>
											<div>
												<select tabindex="3" class="field select large" name="" > 
													<option value="Low">
														Low
													</option>
													<option value="Medium">
														Medium
													</option>
													<option value="High">
														High
													</option>
												</select>
											</div>
										</li>
										<li class="date">
											<label for="Field2" id="title2" class="desc">
												Due Date
											</label>
											<span>
												<input type="text" tabindex="5" maxlength="2" size="2" value="" class="field text" name="" />
												<label >MM</label>
											</span> 
											<span class="symbol">/</span>
											<span>
												<input type="text" tabindex="6" maxlength="2" size="2" value="" class="field text" name="" />
												<label >DD</label>
											</span>
											<span class="symbol">/</span>
											<span>
											 	<input type="text" tabindex="7" maxlength="4" size="4" value="" class="field text" name="" />
												<label >YYYY</label>
											</span>
										</li>
										<li>
											<label for="Field4" id="title4" class="desc">
												Status
											</label>
											<div class="col">
												<span>
													<input type="checkbox" tabindex="8" value="Done." class="field checkbox" name="Field4" id="Field4"/>
													<label for="Field4" class="choice">Done.</label>
												</span>
											</div>
										</li>
										<li class="buttons">
											<input type="submit" value="Submit" class="submit" />
										</li>
									</ul>
								</form>
							</div>
						</div>
						
						<div class="portlet">
							<div class="portlet-header">News</div>
							<div class="portlet-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
						</div>
					
					</div>
					
					<div class="column">
					
						<div class="portlet">
							<div class="portlet-header">Shopping</div>
							<div class="portlet-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
						</div>
					
					</div>
					
					<div class="column">
					
						<div class="portlet">
							<div class="portlet-header">Links</div>
							<div class="portlet-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
						</div>
						
						<div class="portlet">
							<div class="portlet-header">Images</div>
							<div class="portlet-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
<?php include('sidebar.php'); ?>
	</div>
	<div class="clearfix"></div>
<?php include('footer.php'); ?>
</body>
</html>