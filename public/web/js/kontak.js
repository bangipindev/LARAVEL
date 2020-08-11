$(function(){
     $(".btn-accent").click(function(){
        var name    = $("#name").val();
        var email   = $("#email").val();
        var subjek  = $("#subjek").val();
        var pesan   = $("#pesan").val();
        var token   = $("meta[name='csrf-token']").attr("content");
        if (name.length==""){
            Swal.fire({
                type:'warning',
                title:'Oops...',
                text: 'Nama wajib di isi !'
            });
        }
        else if (email.length==""){
            Swal.fire({
                type:'warning',
                title:'Oops...',
                text: 'Email wajib di isi !'
            });
        }
        else if (pesan.length==""){
            Swal.fire({
                type:'warning',
                title:'Oops...',
                text: 'Pesan wajib di isi !'
            });
        }else{
            $.ajax({
                url:"/kontak",
                type:"POST",
                dataType:"JSON",
                cache:false,
                data:{
                    "name":name,
                    "email":email,
                    "subjek":subjek,
                    "pesan":pesan,
                    "_token":token
                },
                success:function(response){
                    if(response.success){
                        Swal.fire({
                            type:'success',
                            title:'Pesan berhasil terkirim',
                            text:'Kami akan membalas pesan anda melalui email',
                            showConfirmButton:true
                        })
                    }
                    else{
                        console.log(response.success);
                        Swal.fire({
                            type:'error',
                            title:'Pesan Gagal terkirim',
                            text:'Silakan coba lagi !'
                        });
                    }
                    console.log(response);
                },
                error:function(response){
                    Swal.fire({
                        type:'error',
                        title:'Oops!',
                        text:'Server Error !'
                    }),
                    console.log(response);
                }
            });
        }
    });
});