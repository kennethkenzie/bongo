"use client";

import Link from "next/link";
import { useRef, useState } from "react";
import { categories } from "@/lib/data";
import { ChevronRight } from "lucide-react";

export default function CategorySidebar() {
  const [activeSlug, setActiveSlug] = useState<string | null>(null);
  const closeTimer = useRef<ReturnType<typeof setTimeout> | null>(null);

  const open = (slug: string) => {
    if (closeTimer.current) clearTimeout(closeTimer.current);
    setActiveSlug(slug);
  };
  // Small delay so moving the cursor between the row and the panel doesn't flicker.
  const scheduleClose = () => {
    if (closeTimer.current) clearTimeout(closeTimer.current);
    closeTimer.current = setTimeout(() => setActiveSlug(null), 120);
  };

  const active = activeSlug ? categories.find((c) => c.slug === activeSlug) : null;

  return (
    <aside
      className="hidden lg:block w-[220px] shrink-0 relative"
      onMouseLeave={scheduleClose}
    >
      <div className="card overflow-hidden">
        <div className="bg-brand-600 text-white px-3 py-2 text-sm font-semibold">
          All Categories
        </div>
        <ul className="py-1">
          {categories.map((c) => {
            const isActive = c.slug === activeSlug;
            return (
              <li key={c.slug} onMouseEnter={() => open(c.slug)}>
                <Link
                  href={`/category/${c.slug}`}
                  className={`flex items-center justify-between px-3 py-1.5 text-sm transition ${
                    isActive
                      ? "bg-brand-50 text-brand-700"
                      : "text-ink-soft hover:bg-brand-50 hover:text-brand-700"
                  }`}
                >
                  <span className="truncate">{c.name}</span>
                  <ChevronRight size={14} className={isActive ? "text-brand-700" : "text-ink-muted"} />
                </Link>
              </li>
            );
          })}
        </ul>
      </div>

      {/* Mega menu panel */}
      {active && (active.groups?.length || active.featured?.length) ? (
        <div
          onMouseEnter={() => open(active.slug)}
          onMouseLeave={scheduleClose}
          className="absolute top-0 left-full ml-1 z-50 w-[760px] xl:w-[860px] bg-white border border-line shadow-pop rounded-sm"
          style={{ minHeight: "100%" }}
        >
          <div className="flex items-center justify-between px-5 py-3 border-b border-line">
            <div>
              <div className="text-xs text-ink-muted">Shop by category</div>
              <Link
                href={`/category/${active.slug}`}
                className="text-lg font-bold text-ink hover:text-brand-700"
              >
                {active.name}
              </Link>
            </div>
            <Link
              href={`/category/${active.slug}`}
              className="text-sm text-brand-700 font-medium hover:underline flex items-center gap-1"
            >
              See all <ChevronRight size={14} />
            </Link>
          </div>

          <div className="flex">
            <div className="flex-1 grid grid-cols-3 xl:grid-cols-4 gap-5 p-5">
              {active.groups?.map((g) => (
                <div key={g.title}>
                  <div className="text-[13px] font-bold text-ink mb-2">{g.title}</div>
                  <ul className="space-y-1.5">
                    {g.links.slice(0, 8).map((l) => (
                      <li key={l}>
                        <Link
                          href={`/search?q=${encodeURIComponent(l)}`}
                          className="text-[12.5px] text-ink-soft hover:text-brand-700 hover:underline"
                        >
                          {l}
                        </Link>
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>

            {active.featured?.length ? (
              <div className="w-[220px] xl:w-[260px] shrink-0 border-l border-line p-3 space-y-2 bg-surface/50">
                {active.featured.slice(0, 3).map((f) => (
                  <Link
                    key={f.title}
                    href={f.href ?? `/category/${active.slug}`}
                    className="block card overflow-hidden hover:border-brand-300 hover:shadow-pop transition"
                  >
                    <div className="relative h-[110px] overflow-hidden">
                      {/* eslint-disable-next-line @next/next/no-img-element */}
                      <img
                        src={f.image}
                        alt={f.title}
                        className="w-full h-full object-cover"
                      />
                    </div>
                    <div className="px-2 py-1.5 text-[12px] font-semibold text-ink line-clamp-1">
                      {f.title}
                    </div>
                  </Link>
                ))}
              </div>
            ) : null}
          </div>
        </div>
      ) : null}
    </aside>
  );
}
