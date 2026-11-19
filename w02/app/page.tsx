import Navbar from "@/components/navbar";
import Footer from "@/components/footer";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

export default function Home() {
  return (
    <div className="max-w-2xl mx-auto p-4">
      <Navbar />
      <Card className="mt-6">
        <CardHeader>
          <CardTitle className="text-3xl">Home</CardTitle>
        </CardHeader>
        <CardContent>
          <p>ยินดีต้อนรับสู่หน้าโปรไฟล์รายวิชา</p>
        </CardContent>
      </Card>
      <Footer />
    </div>
  );
}