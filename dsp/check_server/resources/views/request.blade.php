<html>
    <head>
        <title>sample</title>
        <script type="text/javascript">
            function ajax(){

                var form = document.getElementById("sampleForm");

                var reqData = {"_token": null, "a": null, "b": null, "c": null};
                reqData._token = form._token.value;
                reqData.a = form.a.value;
                reqData.b = form.b.value;
                reqData.c = form.c.value;

                var req = new XMLHttpRequest();
                req.open(form.method, form.action);
                req.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
                req.responseType = 'json';
                req.send(JSON.stringify(reqData));
                req.onload = function () {
                    var json = req.response;
                    alert("a:" + json['a']  + "\n" + "b:" + json['b']+ "\n" + "c:" + json['c']);
                }
            }
        </script>
    </head>
    <body>
        <form id="sampleForm" action="{{ url('request-json2') }}" method="post"  onsubmit="ajax(); return false;">
            <input type="text" name="a" >
            <input type="text" name="b" >
            <input type="text" name="c" >
            <input type="submit" >
        </form>

    </body>
</html>
