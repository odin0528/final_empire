<?php include('header.php'); ?>
	<div id="page-wrapper">
		<div id="main-wrapper">
			<div id="main-content">
				<div class="title title-spacing">
					<h2>Accordion</h2>
					Below you will find an accordion example.
				</div>
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">First</a></li>
						<li><a href="#tabs-2">Second</a></li>
						<li><a href="#tabs-3">Third</a></li>
					</ul>
					<div id="tabs-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
					<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>
					<div id="tabs-3">Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
				</div>
				<div class="clearfix"></div>
				<div class="title title-spacing">
					<h2>Tabs inserted into boxes</h2>
					Below you will find an accordion example. Lorem ipsum dolor sic amet.
				</div>
				<div class="two-column">
					<div class="column-fixed">
						<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all form-container">
							<div class="portlet-header ui-widget-header">Shopping</div>
							<div class="portlet-content">
								<div id="tabs2">
									<ul>
										<li><a href="#tabs-1">First</a></li>
										<li><a href="#tabs-2">Second</a></li>
										<li><a href="#tabs-3">Third</a></li>
									</ul>
									<div id="tabs-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
									<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>
									<div id="tabs-3">Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
								</div>
							</div>
						</div>
					</div>
					<div class="column-fixed">
						<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all form-container">
							<div class="portlet-header ui-widget-header">Form Example</div>
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
													<input type="checkbox" tabindex="8" value="Done." class="field checkbox" name="" />
													<label  class="choice">Done.</label>
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
					</div>
				</div>
				<div class="clearfix"></div>
				<i class="note">* To see more boxes examples, like the ones above, visit for the menu, the Layout Options pages.</i>
			</div>
			<div class="clearfix"></div>
			<?php include('footer.php'); ?>
		</div>
<?php include('sidebar.php'); ?>

	</div>
</body>
</html>