import Link from "next/link";
import { topCategoryShortcuts } from "@/lib/data";

export default function TopCategories() {
  return (
    <section>
      <div className="card p-3 md:p-4">
        <div className="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-12 gap-3">
          {topCategoryShortcuts.map((c) => (
            <Link
              key={c.slug}
              href={`/category/${c.slug}`}
              className="flex flex-col items-center text-center gap-1.5 group"
            >
              <div className="w-14 h-14 md:w-16 md:h-16 rounded-sm overflow-hidden border border-line group-hover:border-brand-400 transition">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src={c.image} alt={c.name} className="w-full h-full object-cover" />
              </div>
              <span className="text-[11px] text-ink-soft group-hover:text-brand-700 line-clamp-2 leading-tight">
                {c.name}
              </span>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
