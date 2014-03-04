// Tecorama RC skin js, version 1.0

var rcmail_editor_settings = { skin : "o2k7", skin_variant : "" };

var xs = new function()
{

	this.init = function()
	{
		if (rcmail.env.task == 'mail')
			rcmail.addEventListener('setquota', xs.update_quota);

		if ($("#message").length)
			$("#topline .topleft").appendTo("#message");
	}

	this.showLoginLogo = function()
	{
		$("#cornerLogoSmall").fadeOut();
		$("#cornerLogoFull").fadeIn();
	}

	this.hideLoginLogo = function()
	{
		$("#cornerLogoSmall").fadeIn();
		$("#cornerLogoFull").fadeOut();
	}

	this.update_quota = function(data)
	{
		xs.percent_indicator(rcmail.gui_objects.quotadisplay, data);
	}

	// percent (quota) indicator
	this.percent_indicator = function(obj, data)
	{
		if (!data || !obj)
			return false;

		var limit_high = 80,
			limit_mid  = 55,
			width = data.width ? data.width : rcmail.env.indicator_width ? rcmail.env.indicator_width : 100,
			height = data.height ? data.height : rcmail.env.indicator_height ? rcmail.env.indicator_height : 14,
			quota = data.percent ? Math.abs(parseInt(data.percent)) : 0,
			quota_width = parseInt(quota / 100 * width),
			pos = $(obj).position();

		// workarounds for Opera and Webkit bugs
		pos.top = Math.max(0, pos.top);
		pos.left = Math.max(0, pos.left);

		rcmail.env.indicator_width = width;
		rcmail.env.indicator_height = height;

		// overlimit
		if (quota_width > width) {
			quota_width = width;
			quota = 100;
		}

		if (data.title)
			data.title = rcmail.get_label('quota') + ': ' +  data.title;

		// main div
		var main = $('<div>');
		main.css({position: 'absolute', top: pos.top, left: pos.left,
				width: width + 'px', height: height + 'px', zIndex: 100, lineHeight: height + 'px'})
			.attr('title', data.title).addClass('quota_text').html(quota + '%');
		// used bar
		var bar1 = $('<div>');
		bar1.css({position: 'absolute', top: pos.top + 1, left: pos.left + 1,
				width: quota_width + 'px', height: height + 'px', zIndex: 99});
		// background
		var bar2 = $('<div>');
		bar2.css({position: 'absolute', top: pos.top + 1, left: pos.left + 1,
				width: width + 'px', height: height + 'px', zIndex: 98})
		.addClass('quota_bg');

		if (quota >= limit_high) {
			main.addClass(' quota_text_high');
			bar1.addClass('quota_high');
		}
		else if(quota >= limit_mid) {
			main.addClass(' quota_text_mid');
			bar1.addClass('quota_mid');
		}
		else {
			main.addClass(' quota_text_low');
			bar1.addClass('quota_low');
		}

		// replace quota image
		$(obj).html('').append(bar1).append(bar2).append(main);
		// update #quotaimg title
		$('#quotaimg').attr('title', data.title);

		return true;
	};
}
