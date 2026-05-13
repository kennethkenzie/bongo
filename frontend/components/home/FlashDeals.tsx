"use client";
import { flashDeals } from "@/lib/data";
import ProductCard from "@/components/product/ProductCard";
import { Flame, ChevronRight } from "lucide-react";
import { useEffect, useState } from "react";

function Countdown() {
  const [t, setT] = useState({ h: 5, m: 32, s: 18 });
  useEffect(() => {
    const id = setInterval(() => {
      setT((p) => {
        let { h, m, s } = p;
        s -= 1;
        if (s < 0) { s = 59; m -= 1; }
        if (m < 0) { m = 59; h -= 1; }
        if (h < 0) { h = 23; }
        return { h, m, s };
      });
    }, 1000);
    return () => clearInterval(id);
  }, []);
  const pad = (n: number) => String(n).padStart(2, "0");
  return (
    <div className="flex items-center gap-1 text-xs">
      <span className="bg-ink text-white px-1.5 py-0.5 rounded-sm font-mono">{pad(t.h)}</span>
      <span className="font-bold">:</span>
      <span className="bg-ink text-white px-1.5 py-0.5 rounded-sm font-mono">{pad(t.m)}</span>
      <span className="font-bold">:</span>
      <span className="bg-ink text-white px-1.5 py-0.5 rounded-sm font-mono">{pad(t.s)}</span>
    </div>
  );
}

export default function FlashDeals() {
  return (
    <section className="mt-5">
      <div className="card overflow-hidden">
        <div className="flex items-center justify-between px-3 py-2.5 bg-gradient-to-r from-deal/10 to-transparent border-b border-line">
          <div className="flex items-center gap-3">
            <div className="flex items-center gap-1.5 text-deal font-extrabold text-lg">
              <Flame size={20} /> Flash Deals
            </div>
            <span className="text-ink-muted text-xs">Ends in</span>
            <Countdown />
          </div>
          <a href="#" className="text-brand-700 text-sm font-medium flex items-center gap-1 hover:underline">
            See all <ChevronRight size={14} />
          </a>
        </div>
        <div className="p-2 md:p-3">
          <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-2 md:gap-3">
            {flashDeals.slice(0, 6).map((p) => (
              <ProductCard key={p.id} product={p} compact />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
