import Link from "next/link";
import { Button } from "@/components/ui/button";

export default function Navbar() {
  return (
    <div className="flex gap-2 p-4 border-b">
      <Link href="/">
        <Button variant="outline">Home</Button>
      </Link>
      <Link href="/bio">
        <Button variant="outline">Bio</Button>
      </Link>
      <Link href="/assignment">
        <Button variant="outline">Assignment</Button>
      </Link>
    </div>
  );
}