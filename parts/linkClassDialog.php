<div id="link-item-dialog" title="Link class">
	<table border="2">
		<tr>
			<td>
				Source:
			</td>
			<td align="center">
				Relation:
			</td>
			<td align="right">
				Destination:
			</td>
		</tr>
		<tr>
            <td>
                <input type="input" name="class" class="text ui-widget-content ui-corner-all" disabled="disabled"/>
                <div class="attribute-selector">
                    Source attribute:
                    <select name="sourceAttribute" class="text ui-widget-content ui-corner-all"></select>
                </div>
			</td>
            <td rowspan="2" align="center">
                <select name="type" class="text ui-widget-content ui-corner-all">
                </select>
            </td>
            <td align="right">
                <select name="destinationItem" class="text ui-widget-content ui-corner-all"></select>
                <div class="attribute-selector">
                    Destination attribute:
                    <select name="destinationAttribute" class="text ui-widget-content ui-corner-all"></select>
                </div>
			</td>
		</tr>
	</table>
</div>

<script>
	$(function() {
        $("#link-item-dialog").dialog({
	        autoOpen: false,
            //height: 300,
            width: 650,
            modal: true,
	        buttons: {
                'Link': function() {
                    LinkClassDialog.prototype.createLink();

                    $( this ).dialog("close");
                },
                Cancel: function() {
                    $( this ).dialog("close");
                }
            }
        });

		LinkClassDialog.prototype.innit();
    });
</script>