<?php
//ไฟล์นี้เป็นไฟล์ตรงกลางที่จะทำงานร่วมกันระหว่าง API กับ Database อีกทีหนึ่ง
//ชื่อไฟล์ และชื่อคลาส ให้ล้อกับตารางที่จะทำงานด้วยใน Database
class Customer
{
    //ประกาศตัวแปรที่ใช้ติดต่อกับ Database
    private $connDB;

    //ประกาศConstructor ที่จะใช้ในการสร้างการเชื่อมกับ Database ผ่านตัวแปรที่สร้างไว้ข้างต้น
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //ประกาศตัวแปรที่มีจำนวนเท่า Column ในตาราง
    public $custId;
    public $custFullname;
    public $custEmail;
    public $custPhone;
    public $custPassword;
    public $custRegisterDate;
    public $modifyDateTime;
    public $custImage;


    //ประกาศตัวแปรสารพัดประโยชน์
    public $message;

    //ฟังก์ชันการทำงานต่างๆ กับตาราง เช่น การเพิ่ม การลบ การแก้ไข การตรวจสอบ การค้นหา การดู .....
    //ฟังก์ชันเพิ่มข้อมูล menu
    public function insertCustomer()
    {
        //ประกาศตัวเก็บคำสั่ง SQL insert ข้อมูลลงตาราง menu_tb
        $strSQL = "INSERT INTO customer_tb 
                        (custFullname,custEmail,custPhone,custPassword,custRegisterDate,custImage)
                    VALUES
                        (:custFullname,:custEmail,:custPhone,:custPassword,:custRegisterDate,:custImage)
                  ";

        //ตรวจสอบข้อมูลที่จะ insert 
        $this->custFullname = htmlspecialchars(strip_tags($this->custFullname));
        $this->custEmail = htmlspecialchars(strip_tags($this->custEmail));
        $this->custPhone = htmlspecialchars(strip_tags($this->custPhone));
        $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));
        $this->custRegisterDate = intval(htmlspecialchars(strip_tags($this->custRegisterDate)));
        $this->custImage = htmlspecialchars(strip_tags($this->custImage));

        echo $strSQL;

        //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
        $stmt = $this->connDB->prepare($strSQL);

        //ก่อนจะสั่งให้ SQL ทำงานจะต้องนำข้อมูลที่ตรวจสอบไปกำหนดให้กับพารามิเตอร์ของคำสั่ง SQL
        $stmt->bindParam(":custFullname", $this->custFullname);
        $stmt->bindParam(":custEmail", $this->custEmail);
        $stmt->bindParam(":custPhone", $this->custPhone);
        $stmt->bindParam(":custPassword", $this->custPassword);
        $stmt->bindParam(":custRegisterDate", $this->custRegisterDate);
        $stmt->bindParam(":custImage", $this->custImage);

        //สั่งให้ SQL ทำงาน
        if ($stmt->execute()) {
            return true;
        } else {
            echo "000";
            return false;
        }
    }
    public function updateCustomer()
    {
        //ตรวจสอบมีการแก้ไขรูปหรือไม่
        if ($this->custImage != "") {
            //ประกาศตัวเก็บคำสั่ง SQL update ข้อมูลลงตาราง menu_tb
            $strSQL = "UPDATE customer_tb 
                    SET custFullname=:custFullname,custEmail=:custEmail,custPhone=:custPhone,
                    custPassword=:custPassword,custImage=:custImage
                    WHERE    custId=:custId
                        
                  ";

            //ตรวจสอบข้อมูลที่จะ update
            $this->custId = intval(htmlspecialchars(strip_tags($this->custId)));
            $this->custFullname = htmlspecialchars(strip_tags($this->custFullname));
            $this->custEmail = htmlspecialchars(strip_tags($this->custEmail));
            $this->custPhone = htmlspecialchars(strip_tags($this->custPhone));
            $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));
            $this->custImage = htmlspecialchars(strip_tags($this->custImage));
           
            //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
            $stmt = $this->connDB->prepare($strSQL);

            //ก่อนจะสั่งให้ SQL ทำงานจะต้องนำข้อมูลที่ตรวจสอบไปกำหนดให้กับพารามิเตอร์ของคำสั่ง SQL
            $stmt->bindParam(":custFullname", $this->custFullname);
            $stmt->bindParam(":custEmail", $this->custEmail);
            $stmt->bindParam(":custPhone", $this->custPhone);
            $stmt->bindParam(":custPassword", $this->custPassword);
            $stmt->bindParam(":custImage", $this->custImage);
            $stmt->bindParam(":custId", $this->custId);
        } else {
             //ไม่แก้ไขรูป
            //ประกาศตัวเก็บคำสั่ง SQL Update ข้อมูลลงตาราง menu_tb
            $strSQL = "UPDATE customer_tb 
            SET   custFullname=:custFullname,custEmail=:custEmail,
                  custPhone=:custPhone,custPassword=:custPassword  
            WHERE    custId=:custId
                
          ";
            //ตรวจสอบข้อมูลที่จะ update
            $this->custId = intval(htmlspecialchars(strip_tags($this->custId)));
            $this->custFullname = htmlspecialchars(strip_tags($this->custFullname));
            $this->custEmail = htmlspecialchars(strip_tags($this->custEmail));
            $this->custPhone = htmlspecialchars(strip_tags($this->custPhone));
            $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));
            //สร้างออปเจ็กต์ statment เพื่อที่จะสั่งให้ SQL ทำงาน
            $stmt = $this->connDB->prepare($strSQL);

            //ก่อนจะสั่งให้ SQL ทำงานจะต้องนำข้อมูลที่ตรวจสอบไปกำหนดให้กับพารามิเตอร์ของคำสั่ง SQL
            $stmt->bindParam(":custFullname", $this->custFullname);
            $stmt->bindParam(":custEmail", $this->custEmail);
            $stmt->bindParam(":custPhone", $this->custPhone);
            $stmt->bindParam(":custPassword", $this->custPassword);
            $stmt->bindParam(":custId", $this->custId);

            //สั่งให้ SQL ทำงาน
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
}
