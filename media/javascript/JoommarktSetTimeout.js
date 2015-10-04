(function (a)
{
    var b = function ()
    {
        var f = this;
        var e = null;
        var d = 2000;
        this.showTestMsgs = function (h, g)
        {
            a("<div/>").attr("id", "joommarkt_msg").prependTo("body").append('<div id="joommarkt_msgtitle">' + h + "</div>").append('<div id="joommarkt_msgtext">' + g + "</div>").css("margin-top", 0).animate({"margin-top": "-150px"}, 300, "linear")
        };
        this.dispatch = function (i) {
            var g = joommarktBaseURI + "index.php?option=com_joommark&format=json";
            var h = {};
            h.task = "stream.display";
            h.nowpage = a(location).attr("href");
            h.initialize = i;
            h.module_available = parseInt(a("#jes_mod").length);
            //alert('before');
            a.ajax({
                url: g,
                data: h,
                type: "post",
                cache: false,
                dataType: "json",
                success: function (j, l, k) {
                   // alert('success');
                },
                error: function (k, l, j) {
                    alert('failure');
                    //alert(j);
                }
            });
            //alert('after');
        };

    };
    window.JoommarktFlow = b;
    a(function () {
        var c = new JoommarktFlow();
        c.dispatch(true);
        //c.showTestMsgs(c.g, 'abc');
    });
})
        (jQuery);