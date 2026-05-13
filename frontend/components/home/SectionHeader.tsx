import Link from "next/link";
import { ChevronRight } from "lucide-react";

export default function SectionHeader({
  title,
  accent,
  href = "#"
}: { title: string; accent?: string; href?: string }) {
  return (
    <div className="flex items-center justify-between mb-3 mt-6">
      <h2 className="section-title flex items-center gap-2">
        <span className="inline-block w-1 h-5 bg-brand-600 rounded-sm" />
        {title}
        {accent ? <span className="text-deal text-sm font-semibold ml-2">{accent}</span> : null}
      </h2>
      <Link href={href} className="text-brand-700 text-sm font-medium flex items-center gap-1 hover:underline">
        View more <ChevronRight size={14} />
      </Link>
    </div>
  );
}
