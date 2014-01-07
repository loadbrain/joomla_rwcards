<?php
/*------------------------------------------------------------------------
# com_rwcards - RWCards for Joomla 3.x
# ------------------------------------------------------------------------
# author Ralf Weber, LoadBrain
# copyright (C) 2011 www.weberr.de. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.weberr.de
# Technical Support: Forum - http://www.weberr.de/forum.html
 -------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 


$separate_front_back = $this->params->get('separate_front_back', true );

// Load the moo.fx scripts
$document = JFactory::getDocument();
JHtml::_('behavior.multiselect');
$document->addStyleSheet( JURI::base() . 'components/com_rwcards/css/rwcards.previewandsend.css', 'text/css', null, array( 'id' => 'StyleSheet' ) );

$separate_front_back = $this->params->get('separate_front_back', true );
$set_height = ($this->params->get('set_height', 1 )) ? $this->params->get('set_height', 1 ) : 0;
$is_enduser = JRequest::getVar("sessionId") != null;

// if we have stuff in the session then we're previewing. Otherwise, the end recipient is viewing.

if ( $this->viewing and !$this->hasData) {
	echo JText::_('COM_RWCARDS_INVALID_CODE');
} else {
	$rwc0 = $this->rwcards[0];
	$sess = @$_SESSION['rwcardsSession'];
	if ( !is_array( $sess ) ) $sess = array();
?>

<div class="congratulations">
	<h1><?php echo (@$sess['picture'] != "") ? JText::_('COM_RWCARDS_CARD_SUCESSFULLY_SENT') : JText::_('COM_RWCARDS_VIEW_YOUR_CARD') . " " . htmlentities($rwc0->nameFrom, ENT_QUOTES, 'UTF-8' ); ?></h1>

	<?php if (@$sess['picture'] != "") echo JText::_('COM_RWCARDS_CONGATULATIONS');
	else if ( $separate_front_back ) echo JText::_('COM_RWCARDS_VIEW_YOUR_CARD_HINT'); ?>
	<br />
	<?php echo (@$sess['picture'] != "") ? JText::_('COM_RWCARDS_CONGATULATIONS_HINT') : ""; ?>
</div>
<div class="rwcardsClr"></div>

<?php if ( $separate_front_back ) { ?>
<p style="text-align:center;">
	<span id="showFrontCard" class="rwcardsLink">
		<?php echo JText::_('COM_RWCARDS_SHOW_FRONT_CARD'); ?></span>&nbsp;&nbsp;<span id="showBackCard" class="rwcardsLink"><?php echo JText::_('COM_RWCARDS_SHOW_BACK_CARD'); ?>
	</span>
</p>
<?php } ?>

<div id="rwcardsViewWrapper" <?php if ( $set_height ) { ?>style="height:<?php echo is_numeric($this->params->get('pageheight')) ? $this->params->get('pageheight') . "px" : $this->params->get('pageheight') ?>;"<?php } ?>>
	<div id="frontCard" <?php echo $separate_front_back ? 'style="display:none;"' : '' ?>>
		<img src='<?php echo JURI::base(); ?>images/rwcards/<?php echo (@$sess['picture'] != "") ? @$sess['picture'] : $this->rwcards[0]->picture; ?>'
			alt='<?php echo @$sess['picture']; ?>'
			hspace='2'
			vspace='2'
			border='0'
			class="theCard">
	</div>
	<div id="backCard" style="<?php echo $separate_front_back ? 'display:none;' : ''; ?>
		<?php if ( $set_width ) { ?>width:<?php echo $this->params->get('pagewidth');?>px;<?php } ?>
		<?php if ( $set_height ) { ?>height:<?php echo is_numeric($this->params->get('pageheight')) ? $this->params->get('pageheight') . "px" : $this->params->get('pageheight');?><?php } ?>">
	<div class="rwcardsfull">
		<div class="rwcardsLeftForm">
			<div class="rw_date"><?php echo date("d.m.Y"); ?></div>
			<p class="rw_from">
				<span class="rw_label"><?php echo $is_enduser ? JText::_('COM_RWCARDS_FROM') : JText::_('COM_RWCARDS_NAME_FROM'); ?></span>
				<br />
				<span class="rw_from_name"><?php echo htmlentities((@$sess['rwCardsFormNameFrom'] != "") ? @$sess['rwCardsFormNameFrom'] : $this->rwcards[0]->nameFrom, ENT_QUOTES, 'UTF-8' ); ?></span>
				<br />
				<span class="rw_from_email"><?php echo htmlentities((@$sess['rwCardsFormEmailFrom'] != "") ? @$sess['rwCardsFormEmailFrom'] : $this->rwcards[0]->emailFrom, ENT_QUOTES, 'UTF-8' ); ?></span>
			</p>
			<p class="rw_message">
				<span class="rw_label"><?php echo JText::_('COM_RWCARDS_MESSAGE');?></span>
				<br />
				<span class="rw_text"><?php echo nl2br( htmlentities( @$sess['rwCardsFormMessage'] != "" ? $sess['rwCardsFormMessage'] : $this->rwcards[0]->message, ENT_QUOTES, 'UTF-8' ) ); ?></span>
			</p>

		</div>
		<div class="rwcardsRightForm">
			<p class="rw_postmark"><img src='<?php echo JURI::base(); ?>/components/com_rwcards/images/postmark.gif' /><img src='<?php echo JURI::base(); ?>/components/com_rwcards/images/stamp.jpg' /></p>
			<p class="rw_to">
				<span class="rw_label"><?php echo $is_enduser ? JText::_('COM_RWCARDS_TO') : JText::_('COM_RWCARDS_NAME_TO');?></span>
			</p>
			<?php
			if ($this->viewCardOnly) {
			?>
				<div id="rwcardsReceiver">
					<p class="rw_receiver">
						<span class="rw_to_name"><?php echo htmlentities( $this->rwcards[0]->nameTo, ENT_QUOTES, 'UTF-8' ); ?></span>
						<br />
						<span class="rw_to_email"><?php echo htmlentities( $this->rwcards[0]->emailTo, ENT_QUOTES, 'UTF-8' ); ?></span>
						<br />
					</p>
				</div>
			<?php
			}
			else {
				if ( count(@$sess['rwCardsFormEmailTo']) > 0 )
				{
					for ($i = 0; $i < count(@$sess['rwCardsFormEmailTo']); $i++)
					{
					?>
				<div id="rwcardsReceiver">
					<p class="rw_receiver">
						<span class="rw_to_name"><?php echo htmlentities( $sess['rwCardsFormNameTo'][$i], ENT_QUOTES, 'UTF-8' ); ?></span>
						<br />
						<span class="rw_to_email"><?php echo htmlentities( $sess['rwCardsFormEmailTo'][$i], ENT_QUOTES, 'UTF-8' ); ?></span>
						<br />
					</p>
				</div>
				<?php
					}
				}
			}
			if ($this->viewCardOnly) {
			?>
			<div id="rwcardsReWriteCard" class="rw_reply_now">
				<div class="rw_reply_image"><img src='<?php echo JURI::base(); ?>/components/com_rwcards/images/rewritecard.jpg'  /></div>
				<div class="rw_reply_text"><?php echo JText::_('COM_RWCARDS_REPLY'); ?></div>
			</div>
			<?php
			}
			?>
			</div>
		<div class="rwcardsClr"></div>
	</div>
	</div>
</div>
<script type="text/javascript">//<![CDATA[
(function($) {
window.addEvent('domready', function()
{
<?php if ( $separate_front_back ) { ?>

    var myCardFx;
    var myEffect = function(cardId){
        return myCardFx = new Fx.Tween(''+cardId+'', {
        duration:550,
        property: 'opacity'
    });

    };

    var setDisplayOfCard = function(myElement, styleProperty){
        $(myElement).setStyle('display', ''+ styleProperty +'');
    };
    
	$('frontCard').setStyle('display', 'inline');

	// Click on ShowFrontCard
	$('showFrontCard').addEvent('click', function()
	{
        myEffect('frontCard').start(0, 1);
		setDisplayOfCard.delay(500, 'backCard',['backCard', 'none']);
        myEffect('backCard').start(1, 0);
        setDisplayOfCard.delay(500, 'frontCard',['frontCard', 'inline']);
	});

	// Click on ShowBackCard
	$('showBackCard').addEvent('click', function()
	{
		myEffect('frontCard').start(1, 0);
        setDisplayOfCard.delay(500, 'frontCard',['frontCard', 'none']);
		setDisplayOfCard.delay(500, 'backCard',['backCard', 'inline']);
		myEffect('backCard').start(0, 1);
	});
<?php } ?>

	// Click on rwcardsReWriteCard
	if ($('rwcardsReWriteCard'))
	{
	$('rwcardsReWriteCard').addEvent('click', function()
	{
	document.location.href='<?php echo str_replace('&amp;', '&', JRoute::_( 'index.php?option=com_rwcards&Itemid=' . $this->Itemid . '&task=rwcardsReWriteCard&sessionId=' . @$this->rwcards[0]->sessionId ) ); ?>'
	});
	}
});
})(document.id);
//]]></script>

<div class="rwcardsClr"></div>
<?php
} // valid data, or sending

// Clear the session so if page is reloaded entry is not saved twice
$_SESSION['rwcardsSession'] = null;
$_SESSION['captcha_success'] = null;
?>