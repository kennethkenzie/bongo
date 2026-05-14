import { Star, ThumbsUp } from "lucide-react";

const reviews = [
  { name: "Asha M.", rating: 5, date: "Mar 12, 2026", title: "Exactly as described", body: "Shipping was fast and the quality is great for the price. Would buy again.", helpful: 24, country: "Tanzania" },
  { name: "James K.", rating: 4, date: "Feb 28, 2026", title: "Great value", body: "Solid product. The color is a tiny bit darker than the photos but I'm still happy with it.", helpful: 12, country: "Kenya" },
  { name: "Pauline N.", rating: 5, date: "Feb 14, 2026", title: "Highly recommend", body: "Packed well, arrived in 6 days. Customer service was responsive when I had a question.", helpful: 8, country: "Uganda" },
  { name: "Daniel B.", rating: 5, date: "Jan 30, 2026", title: "Five stars", body: "Quality exceeded my expectations. Buyer protection gives extra peace of mind.", helpful: 5, country: "United States" },
];

const dist = [
  { stars: 5, pct: 72 },
  { stars: 4, pct: 18 },
  { stars: 3, pct: 6 },
  { stars: 2, pct: 2 },
  { stars: 1, pct: 2 },
];

export default function Reviews({ rating, sold }: { rating: number; sold: number }) {
  const reviewCount = Math.round(sold / 15);
  return (
    <section className="card p-4 mt-3">
      <h2 className="font-bold mb-3 flex items-center gap-2">
        Customer Reviews
        <span className="text-xs font-normal text-ink-muted">({reviewCount.toLocaleString()} reviews)</span>
      </h2>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-4 pb-4 border-b border-line">
        <div className="text-center">
          <div className="text-4xl font-extrabold text-brand-700">{rating.toFixed(1)}</div>
          <div className="flex items-center justify-center gap-0.5 mt-1 text-amber-500">
            {Array.from({ length: 5 }).map((_, i) => (
              <Star key={i} size={14} fill={i < Math.round(rating) ? "currentColor" : "none"} />
            ))}
          </div>
          <div className="text-xs text-ink-muted mt-1">Based on {reviewCount.toLocaleString()} ratings</div>
        </div>
        <div className="md:col-span-2 space-y-1">
          {dist.map((d) => (
            <div key={d.stars} className="flex items-center gap-2 text-xs">
              <span className="w-8 text-ink-muted">{d.stars} ★</span>
              <div className="flex-1 h-2 bg-surface rounded-sm overflow-hidden">
                <div className="h-full bg-brand-600" style={{ width: `${d.pct}%` }} />
              </div>
              <span className="w-10 text-right text-ink-muted">{d.pct}%</span>
            </div>
          ))}
        </div>
      </div>

      <div className="flex items-center gap-2 flex-wrap mt-3 mb-3">
        {["All", "5 ★", "4 ★", "With photos", "Local reviews"].map((f, i) => (
          <button key={f} className={`chip ${i === 0 ? "border-brand-600 text-brand-700 bg-brand-50" : ""}`}>{f}</button>
        ))}
      </div>

      <ul className="divide-y divide-line">
        {reviews.map((r) => (
          <li key={r.name} className="py-3">
            <div className="flex items-center gap-2">
              <div className="w-8 h-8 rounded-sm bg-brand-100 text-brand-700 grid place-items-center font-semibold text-sm">
                {r.name[0]}
              </div>
              <div>
                <div className="text-sm font-medium">{r.name}</div>
                <div className="text-[11px] text-ink-muted">{r.country} · {r.date}</div>
              </div>
              <div className="ml-auto flex items-center gap-0.5 text-amber-500">
                {Array.from({ length: 5 }).map((_, i) => (
                  <Star key={i} size={12} fill={i < r.rating ? "currentColor" : "none"} />
                ))}
              </div>
            </div>
            <div className="mt-2 text-sm font-medium">{r.title}</div>
            <p className="text-sm text-ink-soft">{r.body}</p>
            <button className="mt-2 text-xs text-ink-muted hover:text-brand-700 flex items-center gap-1">
              <ThumbsUp size={12} /> Helpful ({r.helpful})
            </button>
          </li>
        ))}
      </ul>

      <button className="btn-outline w-full mt-3 py-2">Load more reviews</button>
    </section>
  );
}
