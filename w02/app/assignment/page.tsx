import Navbar from "@/components/navbar";
import Footer from "@/components/footer";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

export default function AssignmentPage() {
  return (
    <div className="max-w-2xl mx-auto p-4">
      <Navbar />
      <Card className="mt-6">
        <CardHeader>
          <CardTitle className="text-3xl">Assignment</CardTitle>
        </CardHeader>
        <CardContent className="space-y-2">
          <p><strong>w02:</strong> สร้างหน้าเว็บโปรไฟล์รายวิชา (Home, Bio, Assignment) ด้วย Next.js และ Shadcn UI</p>
        </CardContent>
      </Card>
      <Footer />
    </div>
  );
}