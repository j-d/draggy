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
                    <option value='OneToOne'>One to one</option>
                    <option value='ManyToOne'>Many to one</option>
                    <option value='OneToMany'>One to Many</option>
                    <option value='ManyToMany'>Many to many</option>
                    <option value='Inheritance'>Inherits from</option>
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

	function populateOptions(select,itemName) {
		var s = $(select);
		var item = Item.prototype.getItemByName(itemName);
		var attribute;

		s.children().remove();

        for (var i = 0; i < item.getNumberAttributes(); i++) {
            attribute = item.getAttribute(i);

            s.append('<option value="' + attribute.getName() + '">' + attribute.getName() + '</option>');
        }
	}

    $(function() {
        $("#link-item-dialog").dialog({
	        autoOpen: false,
            //height: 300,
            width: 650,
            modal: true,
            open: function () {
                // Populate options for the first time
                populateOptions('#link-item-dialog select[name=sourceAttribute]',$('#link-item-dialog input[name=class]').val());
                populateOptions('#link-item-dialog select[name=destinationAttribute]',$('#link-item-dialog select[name=destinationItem]').val());
            },
	        buttons: {
                'Link': function() {
                    addLink(
                        $('#link-item-dialog input[name=class]').val(),
                        $('#link-item-dialog select[name=destinationItem]').val(),
                        $('#link-item-dialog select[name=type]').val()
                    );

                    Link.prototype.reDrawLinks();

                    $( this ).dialog("close");
                },
                Cancel: function() {
                    $( this ).dialog("close");
                }
            }
        });


	    $('#link-item-dialog select[name=type]').change(function () {
		    if ($('#link-item-dialog select[name=type]').val() != 'Inheritance') {
                $('#link-item-dialog .attribute-selector').show();
			    populateOptions('#link-item-dialog select[name=sourceAttribute]',$('#link-item-dialog input[name=class]').val());
                populateOptions('#link-item-dialog select[name=destinationAttribute]',$('#link-item-dialog select[name=destinationItem]').val());
		    }
		    else
                $('#link-item-dialog .attribute-selector').hide();
	    });

	    // Change when changing target
        $('#link-item-dialog select[name=destinationItem]').change(function () {
            populateOptions('#link-item-dialog select[name=destinationAttribute]',$('#link-item-dialog select[name=destinationItem]').val());
        });
    });
</script>