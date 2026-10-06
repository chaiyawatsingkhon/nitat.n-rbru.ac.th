# Board Game Collector - Multi-Image Gallery Application

เว็บไซต์สะสมและจัดการข้อมูลบอร์ดเกม (Board Game Collector) พัฒนาด้วย **HTML5, CSS3 และ JavaScript (Vanilla JS)** โดยในเวอร์ชันนี้ได้รับการอัปเกรดระบบแสดงผลรูปภาพจากรูปเดี่ยวให้รองรับ **ภาพชุด/อัลบั้ม (Multi-Image Gallery)** พร้อมระบบเปลี่ยนรูปภาพแบบโต้ตอบ (Interactive Thumbnail Navigation)

---

## 📌 คุณสมบัติหลักของโปรเจกต์ (Features)

1. **Multi-Image Support**: แต่ละรายการบอร์ดเกมรองรับการจัดเก็บรูปภาพหลายรูปในรูปแบบ Array (`images: [...]`)
2. **Dynamic Gallery Switching**: เมื่อคลิกที่รูปภาพย่อ (Thumbnail) รูปภาพหลัก (Main Image) จะเปลี่ยนตามทันทีโดยไม่ต้องโหลดหน้าเว็บใหม่
3. **Active Thumbnail Highlighting**: มีการเน้นขอบสี (Border Highlight) บนรูปภาพย่อที่กำลังถูกเลือกใช้งานอยู่
4. **Local File & Path Handling**: รองรับการดึงรูปภาพจากเครื่องสมาร์ตโฟน/คอมพิวเตอร์ local (ความเร็วสูง) รวมถึงการใช้ภาพจาก URL ออนไลน์
5. **Fallback Image Error Handling**: มีระบบป้องกันภาพแตก (404 Not Found) ด้วยการแสดงรูปภาพสำรองอัตโนมัติหากไม่พบไฟล์รูป

---

## 📂 โครงสร้างโฟลเดอร์ (Project Structure)

```text
w06/
├── index.html        # ไฟล์หลักรวม HTML, CSS และ JavaScript
├── README.md         # เอกสารอธิบายการทำงานของโปรเจกต์
├── catan1.jpg        # รูปภาพบอร์ดเกม Catan (รูปหลัก)
├── catan2.jpg        # รูปภาพบอร์ดเกม Catan (รูปอุปกรณ์)
├── catan3.jpg        # รูปภาพบอร์ดเกม Catan (รูปการเล่น)
├── ttr1.jpg          # รูปภาพ Ticket to Ride
├── ttr2.jpg
├── ttr3.jpg
├── splendor1.jpg     # รูปภาพ Splendor
├── splendor2.jpg
├── splendor3.jpg
├── wingspan1.jpg     # รูปภาพ Wingspan
├── wingspan2.jpg
├── wingspan3.jpg
├── kittens1.jpg      # รูปภาพ Exploding Kittens
├── kittens2.jpg
└── kittens3.jpg