$(document).ready(function(){
    $('#frmUpdateBimbingan .datepicker').datetimepicker({
    	format: "DD-MM-YYYY"
    }).on("dp.change",function(e){
		var tgl_sah = e.date.format("YYYY-MM-DD");
		$("#frmUpdateBimbingan input[name=tgl_sah]").val(tgl_sah); 
	});

    $('#frmCatatanAdd .datepicker').datetimepicker({
    	format: "DD-MM-YYYY"
    }).on("dp.change",function(e){
		var tgl_sah = e.date.format("YYYY-MM-DD");
		$("#frmCatatanAdd input[name=tgl_berikut]").val(tgl_sah); 
	});

    $('#frmUpdateBimbingan .search-button-nim').click(function(){
    	var nim = $("#frmUpdateBimbingan input[name=NIM]").val();

    	if(nim){
	    	$("#frmUpdateBimbingan .search-button-nim").hide();
	    	$("#frmUpdateBimbingan .spinner").removeClass("hide");
	    	$.post("bimbingan/cari-mahasiswa",{"nim":nim},function(data, str, xhr){
	    		if(data.success){
	    			var mhs = data.mahasiswa;
	    			$("#frmUpdateBimbingan .nimmahasiswa").html(mhs.NIM); 
	    			$("#frmUpdateBimbingan .namamahasiswa").html(mhs.nama); 
	    			$("#frmUpdateBimbingan .tahunmasukmahasiswa").html(mhs.tahun_masuk); 
	    			$("#frmUpdateBimbingan input[name=MahasiswaID]").val(mhs.ID); 
	    		}else{
	    			alert("Maaf NIM yang anda masukkan tidak ditemukan atau NIM tersebut sudah melakukan bimbingan.")
	    		}
		    	$("#frmUpdateBimbingan .search-button-nim").show();
		    	$("#frmUpdateBimbingan .spinner").addClass("hide");
	    	},"json");    		
    	}else{
    		alert("Untuk mencari mahasiswa NIM tidak boleh kosong!");
    	}
    });

    $('#frmUpdateBimbingan .btn-choose-dosen').click(function(){
    	var nodosen = $("input[name=dosenpembimbing]:checked ").val();
    	var DosenID = $("select[name=dosen]").val();
    	var nama = $("select[name=dosen] option:selected").text();

    	if(DosenID){
			$("#frmUpdateBimbingan .dosen"+nodosen).html(nama);     		
			$("#frmUpdateBimbingan input[name=Dosen"+nodosen+"ID]").val(DosenID);     		
    	}else{
    		alert("Anda harus memilih dosen!");
    	}
    });

    $("#frmCatatanAdd textarea, .frmBalasan textarea").wysihtml5({
		toolbar: {
		    "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
			"image": false, //Button to insert an image. Default true,
			"color": false, //Button to change color of font
			"link": false,
			"size": "sm"
		}
    });
});