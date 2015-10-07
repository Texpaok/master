(function (a)
{
    var b = function ()
    {
        var f = this;
        var e = null;
        var d = 2000;
        this.showTestMsgs = function (h, g)
        {
            a("<div/>").attr("id", "joommark_msg").prependTo("body").append('<div id="joommark_msgtitle">' + h + "</div>").append('<div id="joommark_msgtext">' + g + "</div>").css("margin-top", 0).animate({"margin-top": "-150px"}, 300, "linear")
        };
        this.dispatch = function (i) {
            var g = joommarkBaseURI + "index.php?option=com_joommark&format=json";
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
    window.JoommarkFlow = b;
    a(function () {
        var c = new JoommarkFlow();
        c.dispatch(true);
        //c.showTestMsgs(c.g, 'abc');
    });
})
        (jQuery);