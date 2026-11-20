// app/page.tsx
import React from "react";
import CatCard, { Cat } from "./components/CatCard";

const cats: Cat[] = [
  {
    id: 1,
    name: "วิเชียรมาศ (Siamese)",
    description:
      "แมวไทยโบราณมงคล ขนสั้นสีครีมอ่อนและมีแต้มสีน้ำตาลเข้ม 9 จุดตามร่างกาย ดวงตาสีฟ้าสดใส นิสัยฉลาด ขี้อ้อน และชอบเข้าสังคม",
    imageUrl:
      "https://images.unsplash.com/photo-1513245543132-31f507417b26?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 2,
    name: "สก็อตติช โฟลด์ (Scottish Fold)",
    description:
      "แมวสายพันธุ์จากสกอตแลนด์ โดดเด่นด้วยใบหูที่พับไปด้านหน้า ใบหน้ากลมคล้ายนกฮูก นิสัยเรียบร้อย อ่อนโยน และเข้ากับคนง่าย",
    imageUrl:
      "https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 3,
    name: "บริติช ช็อตแฮร์ (British Shorthair)",
    description:
      "แมวขนสั้นหนาแน่นจากอังกฤษ รูปร่างกำยำ แก้มยุ้ย ดวงตากลมโตสีทองแดง นิสัยรักสงบ ไม่ซุกซนมาก และมีความเป็นตัวของตัวเองสูง",
    imageUrl:
      "https://images.unsplash.com/photo-1592194996308-7b43878e84a6?auto=format&fit=crop&w=900&q=80",
  },
];

export default function HomePage() {
  return (
    <main
      style={{
        maxWidth: "800px",
        margin: "0 auto",
        padding: "24px",
        fontFamily: "system-ui, -apple-system, BlinkMacSystemFont, sans-serif",
      }}
    >
      <h1 style={{ textAlign: "center", marginBottom: "24px" }}>
        สายพันธุ์แมวยอดนิยม
      </h1>

      {cats.map((cat) => (
        <CatCard key={cat.id} cat={cat} />
      ))}
    </main>
  );
}