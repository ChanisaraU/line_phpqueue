$(function () {

    $("#id_datetime_picker0").datetimepicker();

     $(".css_i_select").on("change",function(){
        var i_select=$(this).val();
         if(i_select=="A"){
            $(this).parents("tr").find(".css_more").show();
         }else{
             $(this).parents("tr").find(".css_more").hide();
         }
    });


    $("#addRow").on("click",function(){
        // ส่วนของการ clone ข้อมูลด้วย jquery clone() ค่า true คือ
        // การกำหนดให้ ไม่ต้องมีการ ดึงข้อมูลจากค่าเดิมมาใช้งาน
        // รีเซ้ตเป็นค่าว่าง ถ้ามีข้อมูลอยู่แล้ว ทั้ง select หรือ input
        $(".datarow:eq(0)").clone(true)
        .find("input").attr("value","").end()
        .find("select").attr("value","").end()  //
        .appendTo($(".place-datarow"));
        var lastIndex=$(".css_datetime_picker").size()-1; // หา index ของตัว input ล่าสุด
        var newId="id_datetime_picker"+lastIndex;
        var objID="#"+newId;
        var placeParent=$(".css_datetime_picker:eq("+lastIndex+")").parents("td");
        // แทนด้วย input ใหม่ ทับตัวเก่าไปเลย
         $(placeParent).html("<input type=\"text\" class=\"form-control css_datetime_picker\" name=\"date_product[]\" >");
        $(".css_datetime_picker:eq("+lastIndex+")")
        .attr("id", newId) // - กำหนด id เป็นค่าใหม่
        .unbind(); // - ยกเลิกการจัดการทั้งหมด ที่ได้มาจากตัว clone
        $(objID).datetimepicker(); // - เรียกใช้ datetimepicker() ใหม่อีกครั้ง

    });

    $("#removeRow").on("click",function(){
        // // ส่วนสำหรับการลบ
        if($(".place-datarow tr").size()>1){ // จะลบรายการได้ อย่างน้อย ต้องมี 1 รายการ
            $(".place-datarow tr:last").remove(); // ลบรายการสุดท้าย
        }else{
            // เหลือ 1 รายการลบไม่ได้
            alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
        }
    });
});
