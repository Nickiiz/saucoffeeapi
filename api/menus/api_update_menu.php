<?php
/*api_update_menu.php เป็น api ที่รับ request ของการนำข้อมูล menu มาแก้ไขบันทึกลงตาราง menu_tb 
และตอบกลับ response ไปยัง client/user ที่เรียกใช้ api ว่าบันทึกเรียบร้อยแล้วหรือไม่*/


//กำหนก Header สำหรับการเรียกใช้งานข้าม Domain และการเข้ารหัวข้อมูลที่ส่งไปมา
header("Access-Control-Allow-Origin:*");
header("Content-Tpye: application/json; charset=UTF-8");

//การเรียกใช้งานไฟล์ที่จำทำงานร้วมกับ api นี้
include_once "./../../connect_db.php"; //จะต้องมีแน่นอนทุกการเรียกใช้
include_once "./../../model/menu.php";

//สร้างตัว Object เพื่อทำงานร่วมกับ Database และ Table ผ่านทาง model ที่สร้างไว้
$connectDB = new ConnectDB();
$connDB = $connectDB->getConnectDB();
$menu = new Menu($connDB);

//สร้างตัวแปร ที่จะรับค่าที่ส่งมาจากฝั่ง Client/User โดยค่าที่ส่งมาเป็น JSON (เนื่องจากใช้ Rest API) จึงต้องมีการ decode ตัว JSON ให้เป็นข้อมูลที่จะนำมาใช้
$data = json_decode(file_get_contents("php://input"));

//ทำการนำข้อมูลที่ผ่านการ decode มากำหนดให้กับตัวแปรที่กำหนดไว้ใน model
$menu->menuId = $data->menuId;
$menu->menuName = $data->menuName;
$menu->menuPrice = $data->menuPrice;
$menu->menuDetail = $data->menuDetail;
$menu->menuStatus = $data->menuStatus;

//รูปตรวจสอบก่อนว่าจะแก้หรือไม่แก้
//แก้รูป
//ในณีที่มีการอัพโหลดรูป ในฐานข้อมูลจะเก็บชื่อรูป ส่วนตัวรูปที่อัพโหลดให้นำไปไว้ที่ที่เรากำหนด
//อีกกรณีนึง รูปที่จะเอาไปไว้ที่ไดเรกทอรี่ images/menus/
if (isset( $data->menuImage)) {
    $menu->menuImage = round(microtime(true) * 1000) . ".jpg"; //ฟังก์ชันในการสุ่ม round(microtime(true)*1000)

    //อัพโหลดรูปไปไว้ในที่ทีกำหนด ถ้าไม่มีการอัพโหลดรูป ข้าม Code นี้ได้
    $image = $data->menuImage;
    file_put_contents("./../../images/menus/" . $menu->menuImage, base64_decode($image));
}
//ไม่แก้รูป
else {
    $menu->menuImage = "";
}
//สั่ง Update ข้อมูลตารางได้ แล้วต้อง Respons บอกว่าสำเร็จหรือไม่สำเร็จ เอา if ครอบ
//บันทึกสำเร็จส่งค่ากลับไปที่ Client/User ว่าสำเร็จ
if ($menu->updateMenu() == true) {;
    http_response_code(200);
    echo json_encode(array("message" => 1));
} else {
    //บันทึกไม่ส่งค่ากลับไปที่ Client/User ว่าไม่สำเร็จ
    http_response_code(200);
    echo json_encode(array("message" => 2));
}
