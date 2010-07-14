$(document).ready(function () {
    $(".dropper").click(function (e) {
        e.preventDefault();
        link = $(this).attr('href');
        $("#dialog-confirm").dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				'No': function() {
					$(this).dialog('close');
				},
				'Yes': function() {
				    $(this).dialog('close');
					document.location = link;
				}
			}
		});
	});
	
	var new_db = $("#new_db");
	var new_coll = $("#new_coll");
    allFields = $([]).add(new_db).add(new_coll),
    tips = $(".validate-tips");

	function updateTips(t)
	{
		tips.text(t).addClass('ui-state-highlight');
		setTimeout(function() {
			tips.removeClass('ui-state-highlight', 1500);
		}, 500);
	}

	function checkLength(o,n,min,max)
	{
        if ( o.val().length > max || o.val().length < min )
        {
			o.addClass('ui-state-error');
			updateTips("Length of " + n + " must be between "+min+" and "+max+".");
			return false;
		}
		else
		{
			return true;
		}

	}
    
    $("#db-create-dialog").dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			},
			'Create Database': function() {
				var bValid = true;
				allFields.removeClass('ui-state-error');
				
				bValid = bValid && checkLength(new_db,"database",1,255);

				if (bValid) {
				    db_name = new_db.val();
				    $(this).dialog('close');
				    
				    document.location = script_name + "?db=" + db_name + "&action=create_db";
				}
			}
		},
		close: function() {
			allFields.val('').removeClass('ui-state-error');
			tips.removeClass('ui-state-highlight');
			tips.text('');
		}
	});
	$('#create-db').click(function() {
		$('#db-create-dialog').dialog('open');
		$('#new_db').focus();
	});

    $("#coll-create-dialog").dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			},
			'Create Collection': function() {
				var bValid = true;
				allFields.removeClass('ui-state-error');
				
				bValid = bValid && checkLength(new_coll,"collection",1,255);

				if (bValid) {
				    coll_name = new_coll.val();
				    $(this).dialog('close');
				    
				    document.location = script_name + "?db=" + current_db + '&c=' + coll_name + "&action=create_coll";
				}
			}
		},
		close: function() {
			allFields.val('').removeClass('ui-state-error');
			tips.removeClass('ui-state-highlight');
			tips.text('');
		}
	});
	$('#create-coll').click(function() {
		$('#coll-create-dialog').dialog('open');
		$('#new_coll').focus();
	});

});