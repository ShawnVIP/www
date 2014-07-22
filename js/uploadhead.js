$(function(){
	
	$(".pickpic").bind({
		click:function(){
			
			$("#pickpicture").click();  
		}
	});
});
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
	
    if(fileSize>=1){
        alert("照片最大尺寸为1MB，请重新上传!");
        return false;
    }
	$(".pickpic").unbind();
	$("#submitpicture").click();  
}