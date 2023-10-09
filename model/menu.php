<?php
//ไฟล์นี้เป็นไฟล์ตรงกลางที่จะทำงานร่วมกันระหว่าง API กับ Database อีกทีหนึ่ง
//ชื่อไฟล์ และชื่อคลาส ให้ล้อกับตารางที่จะทำงานด้วยใน Database
class Menu
{
    //ประกาศตัวแปรที่ใช้ติดต่อกับ Database
    private $connDB;

    //ประกาศConstructor ที่จะใช้ในการสร้างการเชื่อมกับ Database ผ่านตัวแปรที่สร้างไว้ข้างต้น
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //ประกาศตัวแปรที่มีจำนวนเท่า Column ในตาราง
    public $menuId;
    public $menuName;
    public $menuImage;
    public $menuPrice;
    public $menuDetail;
    public $menuStatus;
    public $menuInsertDate;
    public $modifyDateTime;

    //ประกาศตัวแปรสารพัดประโยชน์
    public $message;

    //ฟังก์ชันการทำงานต่างๆ กับตาราง เช่น การเพิ่ม การลบ การแก้ไข การตรวจสอบ การค้นหา การดู .....
    //ฟังก์ชันเพิ่มข้อมูล menu
    public function insertMenu()
    {
        //ประกาศตัวเก็บคำสั่ง SQL insert ข้อมูลลงตาราง menu_tb
        $strSQL = "INSERT INTO menu_tb 
                        (menuName,menuImage,menuPrice,menuDetail,menuStatus,menuInsertDate)
                    VALUES
                        (:menuName,:menuImage,:menuPrice,:menuDetail,:menuStatus,:menuInsertDate)
                  ";

        //ตรวจสอบข้อมูลที่จะ insert 
        $this->menuName = htmlspecialchars(strip_tags($this->menuName));
        $this->menuImage = htmlspecialchars(strip_tags($this->menuImage));
        $this->menuPrice = htmlspecialchars(strip_tags($this->menuPrice));
        $this->menuDetail = htmlspecialchars(strip_tags($this->menuDetail));
        $this->menuStatus = intval(htmlspecialchars(strip_tags($this->menuStatus)));
        $this->menuInsertDate = htmlspecialchars(strip_tags($this->menuInsertDate));

        echo $strSQL;

        //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
        $stmt = $this->connDB->prepare($strSQL);

        //ก่อนจะสั่งให้ SQL ทำงานจะต้องนำข้อมูลที่ตรวจสอบไปกำหนดให้กับพารามิเตอร์ของคำสั่ง SQL
        $stmt->bindParam(":menuName", $this->menuName);
        $stmt->bindParam(":menuImage", $this->menuImage);
        $stmt->bindParam(":menuPrice", $this->menuPrice);
        $stmt->bindParam(":menuDetail", $this->menuDetail);
        $stmt->bindParam(":menuStatus", $this->menuStatus);
        $stmt->bindParam(":menuInsertDate", $this->menuInsertDate);

        //สั่งให้ SQL ทำงาน
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชันแก้ไขข้อ menu
    public function updateMenu()
    {
        //ตรวจสอบมีการแก้ไขรูปหรือไม่
        if ($this->menuImage != "") {
            //แก้ไขรูป
            //ประกาศตัวเก็บคำสั่ง SQL insert ข้อมูลลงตาราง menu_tb
            $strSQL = "UPDATE menu_tb 
        SET menuName=:menuName,menuImage=:menuImage,menuPrice=:menuPrice,
             menuDetail=:menuDetail,menuStatus=:menuStatus
        WHERE
             menuId=:menuId
      ";

            //ตรวจสอบข้อมูลที่จะ update 
            $this->menuName = htmlspecialchars(strip_tags($this->menuName));
            $this->menuImage = htmlspecialchars(strip_tags($this->menuImage));
            $this->menuPrice = htmlspecialchars(strip_tags($this->menuPrice));
            $this->menuDetail = htmlspecialchars(strip_tags($this->menuDetail));
            $this->menuStatus = intval(htmlspecialchars(strip_tags($this->menuStatus)));
            $this->menuId = intval(htmlspecialchars(strip_tags($this->menuId)));

            //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
            $stmt = $this->connDB->prepare($strSQL);

            //ก่อนจะสั่งให้ SQL ทำงานจะต้องนำข้อมูลที่ตรวจสอบไปกำหนดให้กับพารามิเตอร์ของคำสั่ง SQL
            $stmt->bindParam(":menuName", $this->menuName);
            $stmt->bindParam(":menuImage", $this->menuImage);
            $stmt->bindParam(":menuPrice", $this->menuPrice);
            $stmt->bindParam(":menuDetail", $this->menuDetail);
            $stmt->bindParam(":menuStatus", $this->menuStatus);
            $stmt->bindParam(":menuId", $this->menuId);
        } else {
            
            //ไม่แก้ไขรูป
            //ประกาศตัวเก็บคำสั่ง SQL insert ข้อมูลลงตาราง menu_tb
            $strSQL = "UPDATE menu_tb 
        SET menuName=:menuName,menuPrice=:menuPrice,
             menuDetail=:menuDetail,menuStatus=:menuStatus
        WHERE
             menuId=:menuId
      ";

            //ตรวจสอบข้อมูลที่จะ update 
            $this->menuName = htmlspecialchars(strip_tags($this->menuName));
            $this->menuPrice = htmlspecialchars(strip_tags($this->menuPrice));
            $this->menuDetail = htmlspecialchars(strip_tags($this->menuDetail));
            $this->menuStatus = intval(htmlspecialchars(strip_tags($this->menuStatus)));
            $this->menuId = intval(htmlspecialchars(strip_tags($this->menuId)));

            //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
            $stmt = $this->connDB->prepare($strSQL);

            //ก่อนจะสั่งให้ SQL ทำงานจะต้องนำข้อมูลที่ตรวจสอบไปกำหนดให้กับพารามิเตอร์ของคำสั่ง SQL
            $stmt->bindParam(":menuName", $this->menuName);
            $stmt->bindParam(":menuPrice", $this->menuPrice);
            $stmt->bindParam(":menuDetail", $this->menuDetail);
            $stmt->bindParam(":menuStatus", $this->menuStatus);
            $stmt->bindParam(":menuId", $this->menuId);
        }
        //สั่งให้ SQL ทำงาน
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชันลบข้อ menu
    public function deleteMenu()
    {   //กรณีมีรูปจริงๆ แล้วควรเขียนโค๊ดลบรูปก่อนตรงนี้ ก่อนจะไปลบข้อมูลออกจากฐานข้อมูล
        
        //ประกาศตัวเก็บคำสั่ง SQL insert ข้อมูลลงตาราง menu_tb
        $strSQL = "DELETE FROM menu_tb WHERE menuId=:menuId";

        //ตรวจสอบข้อมูลที่จะ delete 
        $this->menuId = htmlspecialchars(strip_tags($this->menuId));

        //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
        $stmt = $this->connDB->prepare($strSQL);

        //ก่อนจะสั่งให้ SQL ทำงานจะต้องนำข้อมูลที่ตรวจสอบไปกำหนดให้กับพารามิเตอร์ของคำสั่ง SQL
        $stmt->bindParam(":menuId", $this->menuId);

        //สั่งให้ SQL ทำงาน
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชัน ดึง/เอา/คิวรี่ ข้อมูล menu ทั้งหมด เอาเฉพาะ menuId menuName menuImage menuDetail menuPrice
    public function getAllMenu()
    {
        //ประกาศตัวเก็บคำสั่ง SQL insert ข้อมูลลงตาราง menu_tb
        $strSQL = "SELECT menuId, menuName, menuImage, menuDetail, menuPrice FROM menu_tb";

        //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
        $stmt = $this->connDB->prepare($strSQL);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ค่าที่ ดึง/เอา/คิวรี่ มาได้จะถูกส่งกลับไปยังจุดที่เรียกใช้ฟังก์ชัน
        return $stmt;
    }
}
