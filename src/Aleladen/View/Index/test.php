<script>
    $("#getLinkForm").submit(function (event) {
        var link = $("#link").val();
        /*var data = {
         url : link
         };

         $.ajax({
         type: "POST",
         url: "result/getResult",
         data: data,
         success: function(res) {
         var objRes = JSON.parse(res);
         $("#result").text("");

         }
         });*/

        var url = "result/getResult";
        $.post(
            url,
            {url: link},
            function (result) {
                result = $.parseJSON(result);

                //display error message
                if (result['message'] !== '') {
                    $('#error').html(result.msg).show();
                }

                var linkData = $.parseJSON(result.data);
                var siteBase = 'http://mp3.zing.vn';
                var imageBase = 'http://image.mp3.zdn.vn';

                if (result.type === 'song-xml' || result.type === 'album-xml') {
                    for (var i = 0; i < linkData.length; i++) {
                        var artist_list = [];
                        var download = [];
                        var item = linkData.data[i];

                        // artisits
                        for (var j = 0; j < item.artist_list.length; j++) {
                            artist_list.push('<a href="' + siteBase + item.artist_list[j].link + '" target="_blank">' + item.artist_list[j].name + '</a>');
                        }

                        // download link
                        for (var j = 0; j < item.source_list.length; j++) {
                            download.push('<a href="' + item.source_base + '/' + item.source_list[j] + '"  target="_blank">Download</a>');
                        }

                        $('#result').append('<p><strong>INFORMATION</strong></p>');
                        $('#result').append('<p><strong>Song: </strong>' + item.name + '</p>');
                        $('#result').append('<p><strong>Artist: </strong>' + artist_list.join(' ft. ') + '</p>');
                        $('#result').append('<p><strong>Download: </strong>' + download.join(', ') + '</p>');
                    }
                } else {
                    $('#result').append('<p><strong>INFORMATION</strong></p>');
                }
            }

        );
        event.preventDefault();
    });
</script>