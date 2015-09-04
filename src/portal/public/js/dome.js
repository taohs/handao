$(function(){ 



$("#protypelist a").each(function(aa){ 
		var aa1 = $("#protypelist a:eq("+aa+")")

	aa1.on("click",function(){ 
				if(aa1.attr("id") == "on"){ 

							aa1.removeAttr("id")

				}else{ 

								aa1.attr("id","on")
				}



	})

})



	$(".t8 li:last span").css("display","none")




	var bth = $(".bottom").css("height")
	var th =$(".top").css("height")
	var bh = $(window).height() -  parseInt(bth) - parseInt(th)
	$(".content").css("min-height",bh)

	$(".tnav li:last").css("background","none")

	$(".t43 li:last").css("margin-right","0")
	$(".fk:first").css("display","block")
	$(".t8 li").each(function(fk){ 
		$(".t8 li:eq("+fk+") a").hover(function(){ 
				$(".t8 li .fk").css("display","none")
				$(".t8 li #sj").attr("class","sj")

				$(".t8 li:eq("+fk+") .fk").css("display","block")
				$(".t8 li:eq("+fk+") #sj").attr("class","opts")
				if(fk == 1){ 
					$(".t8 li:eq("+fk+") #sj").css("left","220px")
				}else if(fk == 2){ 

					$(".t8 li:eq("+fk+") #sj").css("left","415px")
				}else if(fk == 3){ 

					$(".t8 li:eq("+fk+") #sj").css("left","610px")
				}else if(fk == 4){ 

					$(".t8 li:eq("+fk+") #sj").css("left","805px")
				}


		})


	})
	var xs = $(".jr li").length
	var sl = xs
	var li = $(".jr .bl").css("height")
	$(".jr ul").css("height",parseInt(li)+60)
	if(xs>1){ 
		$(".xs").css("display","block")

	}else{
		$(".xs").css("display","none")
	}
	$(".xs a").click(function(){ 
		if(xs>1){ 

			xs-=2
		var sl1 = sl- xs - 1
		var sl2 = sl- xs
			var li1 = parseInt($(".jr li:eq("+sl1+")").css("height")) + 60
			var li2 = parseInt($(".jr li:eq("+sl2+")").css("height")) + 60
			
			var hgg = $(".jr ul").css("height")

			
			
			if(xs>1){ 
				var hg = parseInt(hgg) + li1 + li2
				$(".jr ul").animate({"height":hg})
			}else if(xs <= 1){ 
				hg = parseInt(hgg) + li1
				$(".xs").animate({"opacity":0},function(){ 
					$(".xs a").removeAttr("href")

				})
				$(".jr ul").animate({"height":hg})
				
				
				

			}



		}


	})
	$(".news li:odd").css("float","right")

	var zjg = 0
	$(".jg li").each(function(zj){ 

		var zs = $(".jg li:eq("+zj+")").text()

		zjg += parseInt(zs)




	})
	if(zjg != 0){ 

		$("#zj").text(zjg)



	}
	$(".dlh").css("height",$(document).height())

	$("#close").click(function(){ 

		$(".dlh").css("display","none")


	})
	$("#logined").hover(function(){
		$(this).find("dd").show();	
	},function(){$(this).find("dd").hide();});
	$("#unlogin").click(function(){$(".dlh").css("display","block");});
	$("#login_submit").click(function(){
		var p=$("#login_phone"),s=$("#login_smscode");
		if($.trim(p.val())=="" || $.trim(s.val())==""){
			alert("请输入手机号或验证码!");
			return false;	
		}
		$.post("/e/member/login.php",{"op":"login","phone":$.trim(p.val()),"smscode":$.trim(s.val())},function(data){
			if(data && data.status==1){
				window.location.href=data.data;
			}else{
				alert(data.msg);//window.location.reload();
			}
		},"json").error(function(){alert("服务器响应失败.");});
	});
	$("#login_getsms").click(function(){
		var that=$(this),p=$("#login_phone");
		if("wait"===that.data("status")){
			return false;	
		}
		if(""==$.trim(p.val()) || !(/^1[3-9]{1}[0-9]{9}$/.test(p.val()))){
			alert("请输入有效的手机号码!");	return false;
		}
		that.css("background","#CCCCCC").data("status","wait").text('发送中...');
		p.prop("disabled",true);
		$.post("/e/member/login.php",{"op":"getSMS","phone":$.trim(p.val())},function(data){
			if(data && data.status==1){
				var i=120,succeedtip=function(){
					--i;
					if(0>i){
						p.prop("disabled",false);
						that.css("background","#f8b551").text('重新获取').data("status","resend");return;
					}
					
					that.text(i+"秒后重新获取");
					setTimeout(arguments.callee,1000);
				};
				succeedtip();
			}else{
				p.prop("disabled",false);
				that.css("background","#f8b551").text('重新获取').data("status","resend");
				alert(data.msg);
			}
		},"json").error(function(){p.prop("disabled",false);that.css("background","#f8b551").text('重新获取').data("status","resend");alert("服务器响应失败.");});
	});
});