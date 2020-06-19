$(document).ready(function() {
    
    // var intervalId = setInterval( function () {
    //     if ( element.complete ) {
    //         var width = element.naturalWidth ;
    //         console.log(width);
    //         var height = element.naturalHeight ;
    //         console.log(height);
    
    //         clearInterval( intervalId ) ;
    //     }
    // }, 500 ) ;
    
    // var hight = document.documentElement.scrollHeight;
    // var width = document.documentElement.scrollWidth;
    // alert(hight+"px");

    // var device = 0;
    // var getDevice = (function(){
    //     var ua = navigator.userAgent;
    //     if(ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0){
    //         return 'sp';
    //     }else if(ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0){
    //         return 'tab';
    //     }else{
    //         return 'other';
    //     }
    // })();
    
    // if( getDevice == 'sp' ){
    //     console.log("sp");
    //     device = 3;
    // }else if( getDevice == 'tab' ){
    //     //タブレット
    //     console.log("tab");
    //     device = 2;
    // }else if( getDevice == 'other' ){
    //     //その他
    //     console.log("pc");
    //     device = 1;
    // }

    var width = document.getElementById( "target" ).clientWidth ;
    var height = document.getElementById( "target" ).clientHeight ;
    console.log(width);
    console.log(height);

    var canvas = document.getElementById('heatmapContainerWrapper');
    canvas.style.height = height+"px";
    // canvas.style.width = width+"px";
    canvas.style.width =800+"px";
    var style = canvas.style;

    
    
        // style.height = h+"px";
    // console.log(style);
    // $(document).click(function(e){
    //     // console.log(window.location.href.toString().split(window.location.search)[0]);
    //   log_click(window.location.href.toString().split(window.location.search)[0], e.pageX, e.pageY,device);
    // });
   var param = window.location.search;
   var result = {};
   if(param.length > 0){
       var query = window.location.search.substring( 1 );

        // クエリの区切り記号 (&) で文字列を配列に分割する
        var parameters = query.split( '&' );

        for( var i = 0; i < parameters.length; i++ )
        {
            // パラメータ名とパラメータ値に分割する
            var element = parameters[ i ].split( '=' );

            var paramName = decodeURIComponent( element[ 0 ] );
            var paramValue = decodeURIComponent( element[ 1 ] );

            // パラメータ名をキーとして連想配列に追加する
            result[ paramName ] = paramValue;
        }
        console.log(result);

        if(result["type"] == 1){
            //Click Heatmap
            showHeatmap(result["page"],result["device"],width,height);            
        }else{
            //ScreeTime Heatmap
            showScreenTimeHeatmap(result["page"],result["device"],width,height);
        }
    }
    // var canvas = document.getElementsByTagName('canvas')[0];
    // canvas.style.display = "none";   
});
function showScreenTimeHeatmap(id,device,width,height){
    console.log("screen");
    var img = document.getElementById('show_img');
    var target = document.getElementById('target');
    var img_height = img.naturalHeight ;
    var src = img.getAttribute('src');
    console.log(src);
    let xhr = new XMLHttpRequest(); 
    var param = "?id=" + id+ "&device=" + device+ "&max_height=" + img_height;
    console.log(param);
    
    xhr.open('GET', 'http://54.250.233.86/api/screen_time_heatmap'+param, true);
    xhr.onreadystatechange = function(){
        if (this.readyState === 4 && this.status === 200) {
            var id = this.response.id;
            console.log(id);
        }
    };
    xhr.withCredentials = true;
    // xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send();
    xhr.onload = function() {
        let responseObj = xhr.response;
        var positionData = [
            {
            height: 1000, // The screen height of the visitor's device
            positions: JSON.parse(responseObj)
            //[ 0, 10, 50, 100, 150, 200, 180 , 1000 ] //The scroll positions recorded periodically
            },
            ];
        new Heatmap(
            'target1',
            src,
            positionData
            ,
            {
            screenshotAlpha: 0.6,
            heatmapAlpha: 0.8,
            colorScheme: 'simple' 
            },width,height
            
        );
        target.style.display = "none";
    }
}
function showHeatmap(id,device,width,height){
    let xhr = new XMLHttpRequest();
    // let max_height = document.documentElement.scrollHeight;
    // let max_width = document.documentElement.scrollWidth;
    var param = "?id=" + id+ "&device=" + device+ "&max_height=" + height+ "&max_width=" + width;
    console.log(param);
    
    xhr.open('GET', 'http://54.250.233.86/api/click_heatmap'+param, true);
    xhr.onreadystatechange = function(){
        if (this.readyState === 4 && this.status === 200) {
            var id = this.response.id;
            console.log(id);
        }
    };
    xhr.withCredentials = true;
    // xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send();
    xhr.onload = function() {
            let responseObj = xhr.response;
            // alert(responseObj); // Hello, world!
            var heatmap = h337.create({
                container: document.getElementById('heatmapContainer'),
                maxOpacity: .7,
                radius: 50,
                blur: .90,
                // backgroundColor with alpha so you can see through it
                // backgroundColor: 'rgba(0, 0, 58, 0.96)'
            });
            //   var heatmapContainer = document.getElementById('heatmapContainerWrapper');
            // console.log(JSON.parse(responseObj));
            data = JSON.parse(responseObj);
            console.log(data);
            heatmap.setData({
                data: data
              });

            // if (data.amount > 0){
            //     for (i=0; i< data.amount; i++){
            //         // console.log(data[i]);
            //         var x = data[i].x;
            //         var y = data[i].y;
            //         heatmap.addData({ x: x, y: y, value: 1 });
            //     }
            // }
        };
}
// function log_click(page, x, y,device){ // log clicks for heatmap
    
//     // window.addEventListener('load',function(){
    
//     max_height = document.documentElement.scrollHeight;
//     max_width = document.documentElement.scrollWidth;
//     // });
//     let xhr = new XMLHttpRequest(); 
//     var param = "x_cord=" + x+ "&y_cord=" + y + "&page=" + page + "&device=" + device+ "&max_height=" + max_height+ "&max_width=" + max_width;
//     xhr.open('GET', 'http://54.250.233.86/api/click?'+param, true);
//     xhr.onreadystatechange = function(){
//         if (this.readyState === 4 && this.status === 200) {
//             var id = this.response.id;
//             // console.log(id);
//         }
//     };
    
//     // xhr.responseType = 'json';

//     xhr.withCredentials = true;
//     // xhr.setRequestHeader("Content-Type", "application/json");
//     xhr.send();

//     // レスポンスは {"message": "Hello, world!"}
//     // xhr.onload = function() {
//     //     let responseObj = xhr.response;
//     //     alert(responseObj.message); // Hello, world!
//     // };
// }
