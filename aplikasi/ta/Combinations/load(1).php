jQuery(function($){$('div.vectorMenu').each(function(){var $el=$(this);$el.find('h5:first a:first').click(function(e){$el.find('.menu:first').toggleClass('menuForceShow');e.preventDefault();}).focus(function(){$el.addClass('vectorMenuFocus');}).blur(function(){$el.removeClass('vectorMenuFocus');});});});;mw.loader.state({"skins.vector":"ready"});