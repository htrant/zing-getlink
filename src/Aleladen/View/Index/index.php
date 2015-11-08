<h2>Welcome!</h2>
<div>
    <form id="getLinkForm" method="post" action="">
        <legend>
            <div>
                <label>Enter Link</label>
                <input id="link" name="link" type="text" size="45" />
            </div>
            <div>
                <input type="submit" name="submit" value="Submit" />
            </div>
        </legend>
    </form>
</div>
<div id="res"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#getLinkForm").submit(function(event){
            $('#res').html('');
            var link = $("#link").val();
            url = 'result/getResult';

            $.post(
                url,
                {url: link},
                function(response) {
                    html = "";
                    html += '<p><strong>INFORMATION</strong></p>';
                    var result = jQuery.parseJSON(response);
                    type = result.type;

                    if (type==='song-xml' || type==='album-xml') {
                        var songs = jQuery.parseJSON(result.data);

                        for (var i=0; i<songs.length; i++) {
                            html += '<p><strong>Song name: </strong>' + songs[i].name + '</p>';
                            html += '<p><strong>Artists: </strong>' + songs[i].artist + '</p>';
                            html += '<p><strong>Download: </strong>';
                            var downloads = jQuery.parseJSON(songs[i].download);

                            for (var j=0; j<downloads.length; j++) {
                                html += '<a href="' + downloads[j].link + '">' + downloads[j].quality +  'kbps</a> ';
                            }

                            html += ' </p>';
                        }
                    }
                    $('#res').append(html);
                }
            );  //end post()
            event.preventDefault();
        }); //end submit
    });   //end (document)

</script>

