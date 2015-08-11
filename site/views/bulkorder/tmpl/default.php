<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_bulkorder
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;
$app 	= JFactory::getApplication();
$user 	= JFactory::getUser();
	if ($user->id) {
//pullhikashop stuff
	if(!defined('DS'))
	define('DS', DIRECTORY_SEPARATOR);
	include_once(rtrim(JPATH_ADMINISTRATOR,DS).DS.'components'.DS.'com_hikashop'.DS.'helpers'.DS.'helper.php');
	$checkout = JRoute::_('index.php?option=com_hikashop&view=checkout&layout=step&Itemid=635');
	$update_cart = JRoute::_('index.php?option=com_bulkorder&task=save');

	//load prods
	function prods(){
	    $options = array();
		$db      = JFactory::getDbo();
		$query   = $db->getQuery(true);
		$query->select('product_id, product_name');
		$query->from('#__hikashop_product');
		$query->where('product_published = 1');
		$db->setQuery($query);
		$result = $db->loadObjectList();
		?>
		<select name="product" class="prod_x" required>
					<option> Select Product Name</option>
			<?php
				foreach($result as $row) {
					?>
					<option id="<?php echo $row->product_id ?>"> <?php echo ucwords(strtolower($row->product_name)); ?></option>
					<?php 
				}
			?>
		</select>
		<?php						
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}					
	}
?>
	<h1 class="article-title">Bulk Ordering</h1>
	<hr/>
	<section class="bulkorder article-content clearfix" itemprop="articleBody">
	<div class="col-xs-12">
		<p>
			Hello <b><?php echo ucwords(strtolower($user->name)); ?></b>,
		</p>
		<p>
			<?php echo $this->msg; ?>
		</p>
	</div>
	<div class="col-xs-12">
			<div class="header">
				<div class="col-sm-9" id="pname">
					<b>Product Name</b>
				</div>
				<div class="col-sm-1" id="pqty">
					<b>Qty</b>
				</div>
				<div class="col-sm-2" id="pactions">
					<b>Actions</b>
				</div>
			</div>
			<div class="form-holder">
				<div class="product_ col-xs-12 form-group">
						<div class="selectB col-sm-9">
							<?php
								prods();
							?>
						</div>
						<div class="qtt col-sm-1">
							<span>
								<input type="number" class="qua" required name="quantity" value="1" placeholder="1" style="padding: 0px 1px 0px 5px;">
							</span>
							
						</div>
						<div class="col-sm-2">
							<span>
								<button type="button" class="plus1">
									<span class="glyphicon glyphicon-plus"></span>
								</button>
								<button type="button" class="minus1">
									<span class="glyphicon glyphicon-minus"></span>
								</button>
							</span>					
						</div>
				</div>
			</div>
	</div>

	<div class="col-xs-12 checkout_x bottom_p">
		<div>
		   &nbsp;
	    </div>
	    <div>
		  	<a id="go-to-payment" href="<?php echo $checkout; ?>">
				<button class="btn paynow btn-primary validate col-xs-12 " type="submit">
					Checkout &nbsp;<i class="fa fa-shopping-cart"></i>

				</button>
			</a>
	    </div>

	</div>

	</section>
<?php 
	} else {
		$app->enqueueMessage('You need to be logged in to do a bulk ordering','warning');
	}
?>
<style type="text/css">
	.product_ .chzn-single{
		height: 35px;
	}
	.chzn-container-single {
		width: 100%!important;
	}
	.plus1, 
	.minus1 {
		width: 33px;
		height: 33px;
	}
	.form-holder {
		padding: 13px 0;
	}
	#hikashop_cart .hikashop_cart_input_button {
    	margin: 10px 0px!important;
    	width: 100%!important;
    	height: 35px!important;
	}
</style>

<script type="text/javascript">
   jQuery(function(){
   	function rmv() {
	   	jQuery('.selectB .chzn-container').each(function(index, el) {
	   		if(index > 0) {
	   			jQuery(this).remove();
	   		}
	   	});   
	   	jQuery('.selectB select').each(function(index, el) {
	   		if(index > 0) {
	   			jQuery(this).show();
	   		}
	   	}); 		
   	}
	jQuery('.minus1').each(function(index, el) {
		if(index == 0){
           	jQuery(this).css('display','none');
		} else {
			jQuery(this).css('display','');
		}
	});
	jQuery('button.plus1').live('click',function() {
		var totalp = jQuery('.product_').length;
		var tocopy = jQuery('.product_').first().html();
		jQuery('.product_').last().after('<div class="product_ col-xs-12 form-group '+totalp+'">'+tocopy+'</div>');
		
		jQuery('.minus1').each(function(index, el) {
			if(index == 0){
	           	jQuery(this).css('display','none');
			} else {
				jQuery(this).css('display','');
			}
		});
		rmv();
	});	
   	jQuery('button.minus1').live('click',function() {
		var parentx = jQuery(this).parents('div.product_');
		parentx.fadeOut('slow').remove();
		jQuery('.minus1').each(function(index, el) {
			if(index == 0){
               	jQuery(this).css('display','none');
               	jQuery('button.minus1').live('click',function(){
               		//do 0
               	});
			} else {
				jQuery(this).css('display','');
			}
		});
	});
	
	jQuery('a#go-to-payment').live('click',function(){

		jQuery('select[name="product"] option:selected').each(function(index, el) { 
			var pid 	= jQuery(this).attr('id');
			var pname 	= jQuery(this).text();
			jQuery('.qua').eq(index).attr('id','hikashop_product_quantity_field_'+pid);
			var thissel = jQuery('.qua').eq(index).val(); 
			pid         = parseInt(pid);
			pquantity 	= parseInt(thissel);
			
			if(!pid) {
				pid = 0;
			}
			if(!pquantity) {
				pquantity = 0;
			}
			if(pquantity < 1) {
				pid = 0;
				pquantity = 0;
			}

			if(pid && pquantity > 0){
				jQuery('.paynow').html('Please Wait  &nbsp; <i class="fa fa-spinner fa-spin"></i>');
				jQuery.ajax({
				  url: '<?php echo $update_cart ?>',
				  type: 'POST',
				  data: { 
				  		  pid: pid,
				  		  pquantity: pquantity, 
				  		},
				  complete: function(xhr, textStatus) {
				  	//complete
				  },
				  success: function(data, textStatus, xhr) {
				    console.log('Success');
				    var cartTxt = jQuery(data).find('.hikacart').html();
				    jQuery('.hikacart').empty().html(cartTxt);
				    jQuery.get('<?php echo JURI::getInstance()->toString() ?>', function(data, textStatus, xhr) {
				      	var cartP = jQuery(data).find('#Mod166').html(); 
				    	jQuery('#Mod166').empty().html(cartP);
				    });				    

				    jQuery('.paynow').html('Proceed to Checkout &nbsp;<i class="fa fa-shopping-cart"></i>');
				  },
				  error: function(xhr, textStatus, errorThrown) {
				        console.log(textStatus +' Error');
				  }
				});
				
			} else {
				//console.log('test');
			}			
		});	
		return false;
	});
   });
</script>
