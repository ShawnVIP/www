$(function(){
	
	getBinData();
	
});


function getBinData(){
	
	var outData={totalmode:1};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/getversion.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			info=msg.binlist
			
			for(i=0;i<info.length;i++){
				str="<tr><td>"+info[i].appversion+"</td><td><a href='"+info[i].appurl+"' target='_blank'>"+info[i].appurl+"</a></td><td>"+info[i].hardversion+"</td><td><a href='../"+info[i].binfilename+"' target='_blank'>"+info[i].binfilename+"</a></td><td>"+info[i].update+"</td></tr>";
				$("#myFriendList").append(str);
				
			}
			$('#appversion').val(info[0].appversion);
			$('#appurl').val(info[0].appurl);
			$('#hardversion').val(info[0].hardversion);
			
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		
        }
    });	
		
}

function getPhotoSize(obj){
    photoExt=obj.value.substr(obj.value.lastIndexOf(".")).toLowerCase();//获得文件后缀名
    if(photoExt!='.jpg' && photoExt!='.png'){
        alert("请上传后缀名为jpg或png的照片!");
        return false;
    }
    var fileSize = 0;
    var isIE = /msie/i.test(navigator.userAgent) && !window.opera;           
    if (isIE && !obj.files) {         
         var filePath = obj.value;           
         var fileSystem = new ActiveXObject("Scripting.FileSystemObject");  
         var file = fileSystem.GetFile (filePath);              
         fileSize = file.Size;        
    }else { 
         fileSize = obj.files[0].size;    
    }
	
    fileSize=Math.round(fileSize/(1024*1024)); //单位为MB
	
	
    if(fileSize>1){
        alert("照片最大尺寸为1MB，请重新上传!");
        return false;
    }
	
	$(".pickpic").unbind();
	$("#submitpicture").click();  
	/*
	$('#uploadform').ajaxSubmit({
     type: "post",
     url: "../res/uploadhead.php",
     dataType: "json",
     success: function(result){

           //返回提示信息      
           parent.updatedHead(result.picture);
		   $('#headpic').attr("src","../upload/"+result.picture);
     	}
	 });
	 */
}