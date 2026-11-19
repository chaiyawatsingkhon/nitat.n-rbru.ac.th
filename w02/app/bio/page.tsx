import Navbar from "@/components/navbar";
import Footer from "@/components/footer";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

export default function BioPage() {
  return (
    <div className="max-w-2xl mx-auto p-4">
      <Navbar />
      <Card className="mt-6">
        <CardHeader>
          <CardTitle className="text-3xl">Bio</CardTitle>
        </CardHeader>
        <CardContent className="space-y-2">
          <p><strong>ชื่อ:</strong> ไชยวัฒน์ สิงขรณ์</p>
          <p><strong>รหัสนักศึกษา:</strong> 6714421023</p>
          <p>ส่งงานครับผม</p>
        </CardContent>
      </Card>
      <Footer />
    </div>
  );
}