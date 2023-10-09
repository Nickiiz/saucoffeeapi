<?php
/*api_delete_menu.php เป็น api ที่รับ request ของการนำข้อมูล menu ที่เป็นเงื่อนไขมาลบเมนูนั้นลงตาราง menu_tb 
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







//สั่ง Insert ข้อมูลตารางได้ แล้วต้อง Respons บอกว่าสำเร็จหรือไม่สำเร็จ เอา if ครอบ
//บันทึกสำเร็จส่งค่ากลับไปที่ Client/User ว่าสำเร็จ
if ($menu->deleteMenu() == true) {; 
    http_response_code(200);
    echo json_encode(array("message" => 1));
} else {
//บันทึกไม่ส่งค่ากลับไปที่ Client/User ว่าไม่สำเร็จ
    http_response_code(200);
    echo json_encode(array("message" => 2));
}
