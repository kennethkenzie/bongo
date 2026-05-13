import Link from "next/link";
import { categories } from "@/lib/data";
import { ChevronRight } from "lucide-react";

export default function CategorySidebar() {
  return (
    <aside className="hidden lg:block w-[220px] shrink-0">
      <div className="card overflow-hidden">
        <div className="bg-brand-600 text-white px-3 py-2 text-sm font-semibold">All Categories</div>
        <ul className="py-1">
          {categories.map((c) => (
            <li key={c.slug}>
              <Link
                href={`/category/${c.slug}`}
                className="flex items-center justify-between px-3 py-1.5 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition"
              >
                <span className="truncate">{c.name}</span>
                <ChevronRight size={14} className="text-ink-muted" />
              </Link>
            </li>
          ))}
        </ul>
      </div>
    </aside>
  );
}
